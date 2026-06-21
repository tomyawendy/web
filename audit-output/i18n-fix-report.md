# Planet Aviation i18n Structure Fix Report

Generated: 2026-06-21

## Scope

- English remains the source of truth.
- English UI/content templates were not intentionally redesigned.
- Spanish pages are being aligned to the English structure through shared helpers and templates.

## Automated Audit Added

- Added `scripts/audit-i18n.mjs`.
- Added `scripts/check-i18n-links.mjs`.
- Added `scripts/check-required-files.mjs`.
- Added `package.json` scripts:
  - `npm run audit:i18n`
  - `npm run check:i18n-links`
  - `npm run build`

The audit uses rendered Chrome DOM when InfinityFree returns its JavaScript challenge shell.

## Audit Findings Before This Fix

The rendered audit checked 12 English/Spanish page pairs and found 62 issues:

- Missing `hreflang=en` on 12 Spanish pages.
- Missing `hreflang=es` on 12 Spanish pages.
- Missing `hreflang=x-default` on 12 Spanish pages.
- Missing `canonical` on 12 Spanish pages.
- Spanish internal links lacked explicit `lang=es` on 12 page groups.
- Home page heading structure had one mismatch caused by Spanish Why-card titles using `h3`.
- One decorative hero image was reported as missing alt before the audit was updated to ignore `aria-hidden="true"` images.

## Fixes Applied

- Added `localized_url()` and `localized_current_url()` helpers.
- Added page-aware `canonical`.
- Added page-aware `hreflang` links for `en`, `es`, and `x-default`.
- Added page-aware `og:url`.
- Added Twitter title/description meta output.
- Updated public Header links to preserve language.
- Updated language switcher to preserve the current page.
- Updated public Footer links to preserve language.
- Updated Home, Services, Insights, post detail, contact form, newsletter form, and reusable public sections to use `localized_url()`.
- Changed Spanish-visible Why card titles from `h3` to `.why-card-title` paragraphs so the home page heading hierarchy matches the English baseline.
- Added CSS for `.why-card-title` to preserve the existing visual style.
- Updated the audit script so language-switch links to another locale are not incorrectly reported as Spanish-link failures.
- Updated the audit script so decorative `aria-hidden="true"` images are not incorrectly reported as missing alt text.

## Verification Completed Locally

- `scripts/check-required-files.mjs` passed.
- Public templates no longer contain direct `app_url()` calls.

## Deployment Verification Still Required

Because the i18n audit checks the live rendered site, the final proof requires deployment and then rerunning:

```bash
npm run audit:i18n
npm run check:i18n-links
npm run build
```

Current environment note: the active shell cannot find `git` or `gh`, so deployment was not performed in this continuation turn.
