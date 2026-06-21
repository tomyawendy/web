import fs from 'node:fs/promises';
import http from 'node:http';
import path from 'node:path';
import { existsSync } from 'node:fs';
import { spawn } from 'node:child_process';

const BASE_URL = (process.env.BASE_URL || 'https://tanshan.lovestoblog.com').replace(/\/$/, '');
const OUT_DIR = 'audit-output';
const FETCH_TIMEOUT_MS = Number(process.env.AUDIT_TIMEOUT_MS || 30000);
const CDP_PORT = Number(process.env.AUDIT_CDP_PORT || String(9400 + Math.floor(Math.random() * 400)));
const MAX_PAGES = Number(process.env.AUDIT_MAX_PAGES || 30);
let renderedBrowser = null;
let renderedNavigationCount = 0;
const COMMON_ENGLISH_RESIDUE = [
  'Learn More',
  'Read More',
  'View all',
  'Products & Services',
  'Latest News',
  'Contact Us',
  'Get a Quote',
  'Send Message',
  'Who We Are',
  'Our Services',
  'Insights',
  'Documents',
  'Footer',
  'Back to',
];

function decodeEntities(value = '') {
  return value
    .replace(/&nbsp;/gi, ' ')
    .replace(/&amp;/gi, '&')
    .replace(/&quot;/gi, '"')
    .replace(/&#039;/gi, "'")
    .replace(/&lt;/gi, '<')
    .replace(/&gt;/gi, '>')
    .replace(/&#(\d+);/g, (_, code) => String.fromCodePoint(Number(code)))
    .replace(/&#x([0-9a-f]+);/gi, (_, code) => String.fromCodePoint(parseInt(code, 16)));
}

function stripTags(value = '') {
  return decodeEntities(value.replace(/<script[\s\S]*?<\/script>/gi, ' ').replace(/<style[\s\S]*?<\/style>/gi, ' ').replace(/<[^>]+>/g, ' '))
    .replace(/\s+/g, ' ')
    .trim();
}

function attrs(tag = '') {
  const output = {};
  for (const match of tag.matchAll(/([\w:-]+)\s*=\s*("([^"]*)"|'([^']*)'|([^\s>]+))/g)) {
    output[match[1].toLowerCase()] = decodeEntities(match[3] ?? match[4] ?? match[5] ?? '');
  }
  return output;
}

function makeUrl(path, lang) {
  const url = new URL(path || '/', BASE_URL);
  url.searchParams.set('lang', lang);
  return url.toString();
}

function isInternalHttpUrl(href) {
  if (!href || href.startsWith('#')) return false;
  if (/^(mailto:|tel:|javascript:|data:)/i.test(href)) return false;
  const url = new URL(href, BASE_URL);
  return url.origin === BASE_URL;
}

function normalizeInternalHref(href) {
  const url = new URL(href, BASE_URL);
  url.searchParams.delete('lang');
  const search = url.searchParams.toString();
  return `${url.pathname}${search ? `?${search}` : ''}${url.hash}`;
}

function shouldAuditPath(path) {
  if (!path || path.startsWith('/assets/') || path.startsWith('/admin') || path.includes('/backstage')) return false;
  if (/\.(png|jpe?g|gif|webp|svg|css|js|pdf|docx?|xlsx?)$/i.test(path)) return false;
  return true;
}

async function fetchHtml(url) {
  const controller = new AbortController();
  const timer = setTimeout(() => controller.abort(), FETCH_TIMEOUT_MS);
  try {
    const response = await fetch(url, { signal: controller.signal, redirect: 'follow' });
    const html = await response.text();
    return { ok: response.ok, status: response.status, finalUrl: response.url, html };
  } finally {
    clearTimeout(timer);
  }
}

function wait(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

function requestCdp(requestPath, method = 'GET') {
  return new Promise((resolve, reject) => {
    const req = http.request({ host: '127.0.0.1', port: CDP_PORT, path: requestPath, method }, (res) => {
      let data = '';
      res.on('data', (chunk) => { data += chunk; });
      res.on('end', () => resolve(data));
    });
    req.on('error', reject);
    req.end();
  });
}

function wsSend(ws, method, params = {}) {
  const id = ++ws._id;
  ws.send(JSON.stringify({ id, method, params }));
  return new Promise((resolve, reject) => {
    const timer = setTimeout(() => reject(new Error(`timeout ${method}`)), 90000);
    const handler = (event) => {
      const message = JSON.parse(event.data);
      if (message.id === id) {
        clearTimeout(timer);
        ws.removeEventListener('message', handler);
        message.error ? reject(new Error(JSON.stringify(message.error))) : resolve(message.result || {});
      }
    };
    ws.addEventListener('message', handler);
  });
}

async function openWebSocket() {
  await requestCdp('/json/new?about:blank', 'PUT').catch(() => null);
  const targets = JSON.parse(await requestCdp('/json'));
  const target = targets.find((item) => item.type === 'page' && item.webSocketDebuggerUrl);
  const ws = new WebSocket(target.webSocketDebuggerUrl);
  ws._id = 0;
  await new Promise((resolve, reject) => {
    ws.onopen = resolve;
    ws.onerror = reject;
  });
  return ws;
}

function findChromePath() {
  const candidates = [
    'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
    'C:\\Program Files (x86)\\Google\\Chrome\\Application\\chrome.exe',
    path.join(process.env.LOCALAPPDATA || '', 'Google\\Chrome\\Application\\chrome.exe'),
    'C:\\Program Files\\Microsoft\\Edge\\Application\\msedge.exe',
    'C:\\Program Files (x86)\\Microsoft\\Edge\\Application\\msedge.exe',
  ];
  return candidates.find((candidate) => candidate && existsSync(candidate));
}

async function browserFetchHtml(url) {
  if (!renderedBrowser) {
    renderedBrowser = await openRenderedBrowser();
  }

  const { ws } = renderedBrowser;
  await wsSend(ws, 'Page.navigate', { url });
  await wait(renderedNavigationCount === 0 ? 12000 : 4000);
  renderedNavigationCount += 1;
  const result = await wsSend(ws, 'Runtime.evaluate', {
    expression: 'JSON.stringify({ url: location.href, html: document.documentElement.outerHTML })',
    returnByValue: true,
  });
  const payload = JSON.parse(result.result.value);
  return { ok: true, status: 200, finalUrl: payload.url, html: payload.html };
}

async function openRenderedBrowser() {
  const chromePath = findChromePath();
  if (!chromePath) throw new Error('Chrome or Edge was not found for rendered audit.');
  const profile = path.join(process.env.TEMP || '.', `codex-i18n-audit-${Date.now()}-${Math.random().toString(16).slice(2)}`);
  const chrome = spawn(chromePath, [
    '--headless=new',
    `--remote-debugging-port=${CDP_PORT}`,
    `--user-data-dir=${profile}`,
    '--disable-gpu',
    '--hide-scrollbars',
    'about:blank',
  ], { detached: false, stdio: 'ignore' });

  await wait(1800);
  const ws = await openWebSocket();
  await wsSend(ws, 'Page.enable');
  await wsSend(ws, 'Runtime.enable');
  await wsSend(ws, 'Emulation.setDeviceMetricsOverride', {
    width: 1440,
    height: 1600,
    deviceScaleFactor: 1,
    mobile: false,
  });

  return { chrome, ws };
}

function closeRenderedBrowser() {
  if (!renderedBrowser) return;
  try {
    renderedBrowser.ws.close();
  } catch {
    // The browser may already be closed.
  }
  try {
    renderedBrowser.chrome.kill();
  } catch {
    // The process may already be gone.
  }
  renderedBrowser = null;
}

function collect(html, requestedUrl) {
  const htmlAttrs = attrs((html.match(/<html\b([^>]*)>/i) || [])[1] || '');
  const title = stripTags((html.match(/<title[^>]*>([\s\S]*?)<\/title>/i) || [])[1] || '');
  const body = (html.match(/<body[^>]*>([\s\S]*?)<\/body>/i) || [])[1] || html;
  const visibleText = stripTags(body);

  const meta = {};
  for (const match of html.matchAll(/<meta\b([^>]*)>/gi)) {
    const a = attrs(match[1]);
    const key = a.name || a.property;
    if (key) meta[key] = a.content || '';
  }

  const links = [...html.matchAll(/<a\b([^>]*)>([\s\S]*?)<\/a>/gi)].map((match, index) => {
    const a = attrs(match[1]);
    const href = a.href || '';
    return {
      index,
      text: stripTags(match[2]),
      href,
      normalized: isInternalHttpUrl(href) ? normalizeInternalHref(href) : '',
      className: a.class || '',
      ariaLabel: a['aria-label'] || '',
      langParam: isInternalHttpUrl(href) ? new URL(href, BASE_URL).searchParams.get('lang') || '' : '',
      hasSpanishLang: isInternalHttpUrl(href) ? new URL(href, BASE_URL).searchParams.get('lang') === 'es' : false,
    };
  });

  return {
    requestedUrl,
    lang: htmlAttrs.lang || '',
    title,
    metaDescription: meta.description || '',
    ogTitle: meta['og:title'] || '',
    ogDescription: meta['og:description'] || '',
    headings: [...html.matchAll(/<(h[1-3])\b[^>]*>([\s\S]*?)<\/\1>/gi)].map((match, index) => ({
      index,
      tag: match[1].toLowerCase(),
      text: stripTags(match[2]),
    })),
    sections: [...html.matchAll(/<(header|main|section|footer)\b([^>]*)>/gi)].map((match, index) => {
      const a = attrs(match[2]);
      return {
        index,
        tag: match[1].toLowerCase(),
        id: a.id || '',
        className: a.class || '',
        dataSection: a['data-section'] || '',
      };
    }),
    links,
    buttons: [...html.matchAll(/<button\b([^>]*)>([\s\S]*?)<\/button>/gi)].map((match, index) => {
      const a = attrs(match[1]);
      return { index, text: stripTags(match[2]), className: a.class || '', ariaLabel: a['aria-label'] || '' };
    }),
    images: [...html.matchAll(/<img\b([^>]*)>/gi)].map((match, index) => {
      const a = attrs(match[1]);
      return { index, src: a.src || '', alt: a.alt || '', className: a.class || '', ariaHidden: a['aria-hidden'] || '' };
    }),
    alternates: [...html.matchAll(/<link\b([^>]*)>/gi)]
      .map((match) => attrs(match[1]))
      .filter((a) => (a.rel || '').toLowerCase() === 'alternate')
      .map((a) => ({ hreflang: a.hreflang || '', href: a.href || '' })),
    canonical: ([...html.matchAll(/<link\b([^>]*)>/gi)]
      .map((match) => attrs(match[1]))
      .find((a) => (a.rel || '').toLowerCase() === 'canonical') || {}).href || '',
    englishResidue: COMMON_ENGLISH_RESIDUE.filter((phrase) => visibleText.includes(phrase)),
  };
}

async function collectPage(path, lang) {
  const requestedUrl = makeUrl(path, lang);
  let response = await fetchHtml(requestedUrl);
  if (response.ok && (!/<title[\s>]/i.test(response.html) || /\/aes\.js/i.test(response.html))) {
    response = await browserFetchHtml(requestedUrl);
  }
  return {
    path,
    url: requestedUrl,
    status: response.status,
    ok: response.ok,
    finalUrl: response.finalUrl,
    data: response.ok ? collect(response.html, requestedUrl) : null,
  };
}

function diffPage(key, enPage, esPage) {
  const issues = [];
  if (!enPage?.ok) issues.push({ type: 'en_fetch_failed', detail: enPage?.status ?? 'missing' });
  if (!esPage?.ok) issues.push({ type: 'es_fetch_failed', detail: esPage?.status ?? 'missing' });
  if (!enPage?.data || !esPage?.data) return issues;

  const en = enPage.data;
  const es = esPage.data;
  if (es.lang !== 'es') issues.push({ type: 'html_lang_not_es', detail: es.lang });
  if (!es.title) issues.push({ type: 'missing_es_title' });
  if (!es.metaDescription) issues.push({ type: 'missing_es_meta_description' });
  if (!es.ogTitle) issues.push({ type: 'missing_es_og_title' });
  if (!es.ogDescription) issues.push({ type: 'missing_es_og_description' });
  if (!es.alternates.some((item) => item.hreflang === 'en')) issues.push({ type: 'missing_hreflang_en' });
  if (!es.alternates.some((item) => item.hreflang === 'es')) issues.push({ type: 'missing_hreflang_es' });
  if (!es.alternates.some((item) => item.hreflang === 'x-default')) issues.push({ type: 'missing_hreflang_x_default' });
  if (!es.canonical) issues.push({ type: 'missing_canonical' });

  if (en.headings.map((h) => h.tag).join('|') !== es.headings.map((h) => h.tag).join('|')) {
    issues.push({ type: 'heading_structure_mismatch', en: en.headings, es: es.headings });
  }

  const enSections = en.sections.map((section) => `${section.tag}:${section.id}:${section.className}`).join('|');
  const esSections = es.sections.map((section) => `${section.tag}:${section.id}:${section.className}`).join('|');
  if (enSections !== esSections) {
    issues.push({ type: 'section_structure_mismatch', enCount: en.sections.length, esCount: es.sections.length });
  }

  const missingAlt = es.images.filter((image) => image.src && image.alt.trim() === '' && image.ariaHidden !== 'true');
  if (missingAlt.length) issues.push({ type: 'missing_image_alt', items: missingAlt });

  const esLinksMissingLang = es.links.filter((link) => {
    if (!link.normalized || !shouldAuditPath(link.normalized.split(/[?#]/)[0])) return false;
    if (link.langParam && link.langParam !== 'es') return false;
    return !link.hasSpanishLang;
  });
  if (esLinksMissingLang.length) issues.push({ type: 'es_internal_links_missing_lang', items: esLinksMissingLang });

  if (es.englishResidue.length) issues.push({ type: 'english_residue', items: es.englishResidue });

  return issues.map((issue) => ({ page: key, ...issue }));
}

async function main() {
  await fs.mkdir(OUT_DIR, { recursive: true });
  const homeEn = await collectPage('/', 'en');
  const homeLinks = homeEn.data?.links || [];
  const paths = new Set(['/']);
  for (const link of homeLinks) {
    if (!link.normalized) continue;
    const path = link.normalized.split(/[?#]/)[0] || '/';
    if (shouldAuditPath(path)) paths.add(path);
  }

  const pageMap = [...paths]
    .sort((a, b) => a.localeCompare(b))
    .slice(0, MAX_PAGES)
    .map((path) => ({ key: path === '/' ? 'home' : path.replace(/^\//, '').replace(/[^a-z0-9]+/gi, '_'), path }));
  const en = {};
  const es = {};
  const issues = [];

  for (const page of pageMap) {
    console.error(`Auditing ${page.path}`);
    en[page.key] = await collectPage(page.path, 'en');
    es[page.key] = await collectPage(page.path, 'es');
    issues.push(...diffPage(page.key, en[page.key], es[page.key]));
  }

  const report = {
    baseUrl: BASE_URL,
    generatedAt: new Date().toISOString(),
    pageMap,
    issueCount: issues.length,
    issues,
  };

  await fs.writeFile(`${OUT_DIR}/en-baseline.json`, JSON.stringify(en, null, 2), 'utf8');
  await fs.writeFile(`${OUT_DIR}/es-current.json`, JSON.stringify(es, null, 2), 'utf8');
  await fs.writeFile(`${OUT_DIR}/i18n-diff.json`, JSON.stringify(report, null, 2), 'utf8');
  await fs.writeFile(`${OUT_DIR}/i18n-structure.json`, JSON.stringify({ en, es }, null, 2), 'utf8');

  console.log(JSON.stringify({ baseUrl: BASE_URL, pages: pageMap.length, issueCount: issues.length, output: `${OUT_DIR}/i18n-diff.json` }, null, 2));
}

main()
  .finally(() => closeRenderedBrowser())
  .catch((error) => {
    console.error(error);
    process.exit(1);
  });
