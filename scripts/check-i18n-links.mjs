import fs from 'node:fs/promises';
import { spawn } from 'node:child_process';

const REPORT_PATH = 'audit-output/i18n-diff.json';

async function exists(path) {
  try {
    await fs.access(path);
    return true;
  } catch {
    return false;
  }
}

function runAudit() {
  return new Promise((resolve, reject) => {
    const child = spawn(process.execPath, ['scripts/audit-i18n.mjs'], { stdio: 'inherit' });
    child.on('exit', (code) => {
      code === 0 ? resolve() : reject(new Error(`audit-i18n exited with ${code}`));
    });
    child.on('error', reject);
  });
}

async function main() {
  if (!(await exists(REPORT_PATH))) {
    await runAudit();
  }

  const report = JSON.parse(await fs.readFile(REPORT_PATH, 'utf8'));
  const blockingTypes = new Set([
    'es_fetch_failed',
    'es_internal_links_missing_lang',
    'section_structure_mismatch',
    'heading_structure_mismatch',
  ]);
  const blocking = (report.issues || []).filter((issue) => blockingTypes.has(issue.type));

  if (blocking.length) {
    console.error(JSON.stringify({ ok: false, blockingCount: blocking.length, blocking }, null, 2));
    process.exit(1);
  }

  console.log(JSON.stringify({ ok: true, checkedPages: report.pageMap?.length || 0, issueCount: report.issueCount || 0 }, null, 2));
}

main().catch((error) => {
  console.error(error);
  process.exit(1);
});
