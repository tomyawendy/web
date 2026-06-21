import fs from 'node:fs/promises';

const requiredFiles = [
  'public/index.php',
  'public/router.php',
  'public/assets/css/design-tokens.css',
  'public/assets/css/site-main.css',
  'resources/views/layouts/public.php',
  'resources/views/public/home_v2.php',
  'resources/views/public/components/header.php',
  'resources/views/public/components/footer.php',
  'resources/views/public/services/index.php',
  'resources/views/public/services/show.php',
  'resources/views/public/posts/index.php',
  'resources/views/public/posts/show.php',
  'resources/views/public/partials/contact_block.php',
  'resources/views/public/partials/newsletter.php',
  'database/schema.sql',
];

async function main() {
  const missing = [];
  for (const file of requiredFiles) {
    try {
      await fs.access(file);
    } catch {
      missing.push(file);
    }
  }

  if (missing.length) {
    console.error(JSON.stringify({ ok: false, missing }, null, 2));
    process.exit(1);
  }

  console.log(JSON.stringify({ ok: true, checked: requiredFiles.length }, null, 2));
}

main().catch((error) => {
  console.error(error);
  process.exit(1);
});
