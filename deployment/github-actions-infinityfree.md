# GitHub Actions Deploy To InfinityFree

This project can be deployed from GitHub Actions instead of a local FTP client.

## Required GitHub Secrets

Add these repository secrets in GitHub:

- `INFINITYFREE_FTP_SERVER`: `ftpupload.net`
- `INFINITYFREE_FTP_USERNAME`: your hosting account username, for example `if0_42121917`
- `INFINITYFREE_FTP_PASSWORD`: your hosting account / control panel password
- `INFINITYFREE_DB_HOST`: your MySQL host, for example `sql106.infinityfree.com`
- `INFINITYFREE_DB_DATABASE`: your MySQL database name
- `INFINITYFREE_DB_USERNAME`: your MySQL username
- `INFINITYFREE_DB_PASSWORD`: your MySQL password

## Run Deployment

1. Open the GitHub repository.
2. Go to `Actions`.
3. Choose `Deploy to InfinityFree`.
4. Click `Run workflow`.

The workflow first syncs the source folders into the deploy package, then uploads:

```text
outputs/infinityfree-htdocs-package/htdocs/
```

to:

```text
htdocs/
```

## Notes

- Do not upload the zip file to InfinityFree. The free plan has small single-file upload limits.
- Keep the remote directory as `htdocs/`, otherwise the website files may not be served.
- The workflow is manual only, so a normal code push will not deploy automatically.
- The workflow excludes `assets/uploads/**` so CMS-uploaded images and documents are not overwritten by code deployment.
- Code deployment does not change the MySQL structure. Import new SQL files from `database/patches/` in phpMyAdmin when a patch is listed in the release notes.
- For the CMS operations update, import `database/patches/2026_06_14_cms_operations.sql` once before using Contact Leads status or Newsletter status actions.
- For the Spanish frontend content update, import `database/patches/2026_06_14_spanish_frontend.sql` once after the CMS operations patch.
- The Spanish patch is ASCII-safe to reduce shared-hosting encoding issues. Still keep the database charset as `utf8mb4`.
- Do not import the same patch twice. If phpMyAdmin says a column already exists, stop and confirm the patch has already been applied.
- For source, database, and uploads backup, follow `deployment/source-backup-and-handover.md`.
