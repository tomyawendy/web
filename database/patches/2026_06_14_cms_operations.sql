-- Planet Aviation CMS operations patch
-- Import this file in phpMyAdmin after the current schema is already live.

ALTER TABLE contact_submissions
    ADD COLUMN status VARCHAR(30) NOT NULL DEFAULT 'new' AFTER locale,
    ADD COLUMN admin_note TEXT DEFAULT NULL AFTER status,
    ADD COLUMN updated_at DATETIME DEFAULT NULL AFTER admin_note;

ALTER TABLE newsletter_subscriptions
    ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER source_path,
    ADD COLUMN unsubscribed_at DATETIME DEFAULT NULL AFTER is_active;

ALTER TABLE posts
    ADD COLUMN attachment_description TEXT DEFAULT NULL AFTER attachment_name;

ALTER TABLE media
    ADD COLUMN alt_text VARCHAR(255) DEFAULT NULL AFTER file_size;

ALTER TABLE admins
    ADD COLUMN last_login_at DATETIME DEFAULT NULL AFTER is_active,
    ADD COLUMN last_login_ip VARCHAR(50) DEFAULT NULL AFTER last_login_at;

INSERT IGNORE INTO permissions (slug, name)
VALUES ('manage_logs', 'Manage Operation Logs');

UPDATE contact_submissions
SET status = 'new'
WHERE status IS NULL OR status = '';

INSERT INTO site_settings (locale, setting_key, setting_value, updated_at) VALUES
('en', 'site_meta_title', 'Planet Aviation', NOW()),
('en', 'site_meta_keywords', 'aviation, air cargo, logistics, GSSA', NOW()),
('en', 'site_meta_description', 'Planet Aviation provides air cargo, GSSA, logistics, handling, trucking, and insurance solutions.', NOW()),
('en', 'site_og_image', 'assets/figma/hero-plane.png', NOW()),
('en', 'homepage_meta_title', 'Premium Choice For Air Logistics Solution!', NOW()),
('en', 'homepage_meta_keywords', 'air logistics, air cargo, GSSA, freight forwarding', NOW()),
('en', 'homepage_meta_description', 'Specializing in air freight operations across Europe, Asia, Middle East and Latin America.', NOW()),
('en', 'homepage_og_image', 'assets/figma/hero-plane.png', NOW()),
('es', 'site_meta_title', 'Planet Aviation', NOW()),
('es', 'site_meta_keywords', 'aviacion, carga aerea, logistica, GSSA', NOW()),
('es', 'site_meta_description', 'Planet Aviation ofrece soluciones de carga aerea, GSSA, logistica, handling, transporte terrestre y seguros.', NOW()),
('es', 'site_og_image', 'assets/figma/hero-plane.png', NOW()),
('es', 'homepage_meta_title', 'Soluciones premium para logistica aerea', NOW()),
('es', 'homepage_meta_keywords', 'logistica aerea, carga aerea, GSSA, transitarios', NOW()),
('es', 'homepage_meta_description', 'Especialistas en operaciones de carga aerea en Europa, Asia, Oriente Medio y America Latina.', NOW()),
('es', 'homepage_og_image', 'assets/figma/hero-plane.png', NOW())
ON DUPLICATE KEY UPDATE
setting_value = VALUES(setting_value),
updated_at = NOW();

-- Current phase uses English and Spanish only. Remove historical Chinese rows.
DELETE FROM page_translations WHERE locale = 'zh';
DELETE FROM service_translations WHERE locale = 'zh';
DELETE FROM post_translations WHERE locale = 'zh';
DELETE FROM banner_translations WHERE locale = 'zh';
DELETE FROM site_settings WHERE locale = 'zh';
