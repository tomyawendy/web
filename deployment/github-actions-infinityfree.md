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

The workflow uploads:

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
