# Planet Aviation Website & CMS

Traditional `PHP + MySQL` website and backstage CMS for Planet Aviation. The project is structured for standard hosting environments and keeps the frontend and admin in one deployable application.

## Features

- Bilingual public website with `English` as the default language and `Spanish` as a manual-switch language
- Figma-aligned homepage, Who We Are page, Our Services page, Insights listing/detail, Documents listing/detail, and Contact sections
- Admin login, logout, password change, and role-based permissions
- CMS modules for pages, services, insights, documents, banners, media library, site settings, SEO settings, contact leads, newsletter subscribers, administrators, and operation logs
- Attachment upload support for document-style posts
- Activity logging for important admin actions

## Folder Structure

- `public/`: web root, front controller, assets, upload target
- `public/router.php`: local development router for the PHP built-in server
- `app/`: core classes, controllers, repositories, services
- `resources/views/`: public and admin templates
- `database/schema.sql`: database structure
- `database/seeds/seed.sql`: starter content and default admin

## Environment

Minimum recommended environment:

- PHP 8.1+
- MySQL 5.7+ or MariaDB equivalent
- Apache or Nginx with document root pointing to `public/`

Set these environment variables when available:

- `APP_URL`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

If environment variables are not configured, defaults are loaded from [config/app.php](/C:/Users/31318/Documents/Codex/2026-06-07/planet-aviation-ui-ai-agent-ps/config/app.php) and [config/database.php](/C:/Users/31318/Documents/Codex/2026-06-07/planet-aviation-ui-ai-agent-ps/config/database.php).

## Installation

1. Create a MySQL database, for example `planet_aviation`.
2. Import [database/schema.sql](/C:/Users/31318/Documents/Codex/2026-06-07/planet-aviation-ui-ai-agent-ps/database/schema.sql).
3. Import [database/seeds/seed.sql](/C:/Users/31318/Documents/Codex/2026-06-07/planet-aviation-ui-ai-agent-ps/database/seeds/seed.sql).
4. Point the site document root to [public/index.php](/C:/Users/31318/Documents/Codex/2026-06-07/planet-aviation-ui-ai-agent-ps/public/index.php).
5. Ensure `public/assets/uploads/` is writable.
6. Configure `APP_URL` so generated links match the real domain.

## Default Admin

- Login URL: `/backstage/login`
- Username: `admin`
- Password: `admin123456`

The seed uses a first-login fallback format for the default password. After first login, use the dashboard password form to replace it with a hashed password.

## Deployment Notes

- For Apache, keep [public/.htaccess](/C:/Users/31318/Documents/Codex/2026-06-07/planet-aviation-ui-ai-agent-ps/public/.htaccess) enabled.
- For Nginx, route all non-file requests to `public/index.php`.
- For local PHP built-in server testing, use `public/router.php` so static assets are served correctly.
- Uploaded files are served from `public/assets/uploads/`.
- The current frontend structure has been reshaped around the confirmed Figma information architecture, and the backend fields now map to those frontend modules.

### InfinityFree quick notes

- This project can be deployed on InfinityFree as a temporary demo site.
- Keep the application folders (`app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `routes/`, `storage/`, `work/`) above `htdocs`.
- Put the contents of `public/` inside `htdocs/`.
- Update `config/database.php` with the InfinityFree MySQL credentials.
- Update `config/app.php` so `url` matches the final site URL.
- Make sure `public/assets/uploads/` is writable after upload.
- See [deployment/infinityfree.md](/C:/Users/31318/Documents/Codex/2026-06-07/planet-aviation-ui-ai-agent-ps/deployment/infinityfree.md) for the full upload order.

## Important Notes

- The backend is intentionally stronger than a generic news-only CMS: it separates pages, services, insights, documents, banners, media, site settings, SEO settings, contact leads, newsletter subscribers, administrators, and logs.
- Newsletter subscriptions are stored separately from contact leads and can be reviewed in the backstage CMS.
- The project does not yet include enterprise approval workflows, OA features, or ERP/CRM integrations.
- Final runtime verification should be completed after deployment, including frontend pages, admin login, media upload, contact submissions, newsletter subscriptions, and 404 handling.
