# InfinityFree Deployment Guide

This guide is for the free InfinityFree hosting account used as a temporary demo environment for Planet Aviation.

## What this hosting is good for

- Previewing the frontend
- Checking admin login and basic CMS flows
- Showing the client a live test site

## What this hosting is not ideal for

- Long-term production use
- Heavy file uploads
- High traffic
- Email-heavy workflows

## Final folder layout

Upload the project so `htdocs` looks like this:

```text
htdocs/
  index.php
  .htaccess
  assets/
  app/
  bootstrap/
  config/
  database/
  resources/
  routes/
  storage/
```

InfinityFree free hosting restricts PHP file access to `htdocs`, so the PHP application folders must also live inside `htdocs`.

## Upload order

1. Create the hosting account and database in InfinityFree.
2. Upload the application folders to the account root.
3. Upload the contents of the prepared package `htdocs/` into the hosting `htdocs/` directory.
4. Import the database schema.
5. Import the seed data.
6. Edit the config files with the live database values.
7. Open the site and verify the public pages and the backstage login.

## Files to update

### `config/database.php`

Replace the default database values with the InfinityFree values:

- `host`
- `database`
- `username`
- `password`

### `config/app.php`

Set:

```php
'url' => 'https://tanshan.lovestoblog.com',
```

or your actual live domain.

## Database import

Import these files into the new MySQL database:

- `database/schema.sql`
- `database/seeds/seed.sql`

## Writable directory

Make sure this folder is writable:

`public/assets/uploads/`

If uploads fail, check this folder first. On InfinityFree, this path is normally `htdocs/assets/uploads/`.

## What to test after upload

- `https://tanshan.lovestoblog.com/`
- `https://tanshan.lovestoblog.com/about`
- `https://tanshan.lovestoblog.com/services`
- `https://tanshan.lovestoblog.com/insights`
- `https://tanshan.lovestoblog.com/documents`
- `https://tanshan.lovestoblog.com/contact`
- `https://tanshan.lovestoblog.com/backstage/login`

Default backstage login:

- Username: `admin`
- Password: `admin123456`

## Common fixes

- If the site shows a 500 error, check the database credentials first.
- If images do not load, confirm `htdocs/assets/` exists and the files were uploaded.
- If uploads fail, confirm `public/assets/uploads/` is writable.
- If links look wrong, verify `config/app.php` has the live URL.
