# Planet Aviation Frontend / CMS Mapping

This document explains which frontend areas are editable from the CMS and which areas are locked to preserve the approved Figma visual.

## Language Scope

- Default public language: English.
- Manual-switch public language: Spanish.
- CMS editing fields: English and Spanish only.

## Editable Now

| Frontend area | CMS entry | Notes |
| --- | --- | --- |
| Header navigation | Site Settings | Navigation labels are editable in English and Spanish. Links are fixed to protect routing. |
| Homepage text and labels | Home Page / Site Settings | Hero copy, lookup labels, homepage section labels, contact labels, newsletter labels, and footer copy are editable. |
| Homepage SEO | SEO Settings | Homepage meta title, keywords, description, and share image are editable. |
| Who We Are page | Pages | English and Spanish title, excerpt, content, SEO fields, and SEO image are editable. |
| Services list and detail pages | Services | Title, summary, content, cover path, status, order, and SEO are editable. |
| Insights list and detail pages | Insights | Title, summary, content, cover path, status, category, pinned, featured, date, bulk actions, and SEO are editable. |
| Documents list and detail pages | Documents | Title, summary, content, attachment, attachment description, status, category, pinned, featured, date, bulk actions, and SEO are editable. |
| Contact form submissions | Contact Leads | Leads can be reviewed and marked as new, in progress, or done after the database patch is imported. |
| Newsletter subscribers | Newsletter Subscribers | Submissions can be reviewed from the CMS. |
| Images and documents | Media Library | Upload once, preview, copy the stored path, and delete unused uploaded files. |
| Site-level SEO | SEO Settings | Default meta title, keywords, description, and share image are editable. |

## Figma-Locked Areas

These areas use fixed Figma-aligned visual assets or carefully aligned layout. Do not casually replace them from CMS fields unless a new screenshot comparison pass is planned.

| Frontend area | Reason |
| --- | --- |
| Homepage hero | Approved visual alignment depends on fixed image scale and overlay geometry. |
| Homepage section stage images | Some sections use exported Figma assets to preserve 1:1 visual fidelity. |
| Insights first visual strip | Uses the approved Figma stage image with clickable hotspots to prevent image-crop artifacts. |
| Footer visual arrangement | Keep layout stable unless the approved UI changes. |

## Operating Rule

If a field is edited in the CMS but does not visually change a Figma-locked area, this is expected. Convert that section to fully editable HTML only after a planned Figma comparison pass.
