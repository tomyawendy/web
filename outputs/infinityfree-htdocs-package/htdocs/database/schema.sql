CREATE TABLE roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE permissions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL
);

CREATE TABLE role_permissions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,
    UNIQUE KEY unique_role_permission (role_id, permission_id)
);

CREATE TABLE admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role_id INT UNSIGNED NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(150) DEFAULT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE pages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(150) NOT NULL UNIQUE,
    template VARCHAR(80) NOT NULL DEFAULT 'default',
    status VARCHAR(30) NOT NULL DEFAULT 'draft',
    sort_order INT NOT NULL DEFAULT 0,
    seo_image VARCHAR(255) DEFAULT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE page_translations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    page_id INT UNSIGNED NOT NULL,
    locale VARCHAR(10) NOT NULL,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT DEFAULT NULL,
    content LONGTEXT DEFAULT NULL,
    seo_title VARCHAR(255) DEFAULT NULL,
    seo_keywords VARCHAR(255) DEFAULT NULL,
    seo_description TEXT DEFAULT NULL,
    UNIQUE KEY unique_page_locale (page_id, locale)
);

CREATE TABLE services (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(150) NOT NULL UNIQUE,
    icon VARCHAR(80) DEFAULT NULL,
    cover_image VARCHAR(255) DEFAULT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'draft',
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE service_translations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    service_id INT UNSIGNED NOT NULL,
    locale VARCHAR(10) NOT NULL,
    title VARCHAR(255) NOT NULL,
    summary TEXT DEFAULT NULL,
    content LONGTEXT DEFAULT NULL,
    seo_title VARCHAR(255) DEFAULT NULL,
    seo_keywords VARCHAR(255) DEFAULT NULL,
    seo_description TEXT DEFAULT NULL,
    UNIQUE KEY unique_service_locale (service_id, locale)
);

CREATE TABLE post_categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    name VARCHAR(150) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0
);

CREATE TABLE posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    category_id INT UNSIGNED DEFAULT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    cover_image VARCHAR(255) DEFAULT NULL,
    attachment_path VARCHAR(255) DEFAULT NULL,
    attachment_name VARCHAR(255) DEFAULT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'draft',
    is_pinned TINYINT(1) NOT NULL DEFAULT 0,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    sort_order INT NOT NULL DEFAULT 0,
    published_at DATETIME DEFAULT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE post_translations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id INT UNSIGNED NOT NULL,
    locale VARCHAR(10) NOT NULL,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT DEFAULT NULL,
    content LONGTEXT DEFAULT NULL,
    seo_title VARCHAR(255) DEFAULT NULL,
    seo_keywords VARCHAR(255) DEFAULT NULL,
    seo_description TEXT DEFAULT NULL,
    UNIQUE KEY unique_post_locale (post_id, locale)
);

CREATE TABLE banners (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) DEFAULT NULL,
    link VARCHAR(255) DEFAULT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'draft',
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL
);

CREATE TABLE banner_translations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    banner_id INT UNSIGNED NOT NULL,
    locale VARCHAR(10) NOT NULL,
    title VARCHAR(255) NOT NULL,
    subtitle TEXT DEFAULT NULL,
    button_text VARCHAR(120) DEFAULT NULL,
    UNIQUE KEY unique_banner_locale (banner_id, locale)
);

CREATE TABLE site_settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    locale VARCHAR(10) NOT NULL,
    setting_key VARCHAR(100) NOT NULL,
    setting_value LONGTEXT DEFAULT NULL,
    updated_at DATETIME NOT NULL,
    UNIQUE KEY unique_setting_locale (locale, setting_key)
);

CREATE TABLE media (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(30) NOT NULL,
    mime_type VARCHAR(120) DEFAULT NULL,
    file_size INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL
);

CREATE TABLE contact_submissions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    company VARCHAR(150) DEFAULT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(80) DEFAULT NULL,
    subject VARCHAR(255) DEFAULT NULL,
    message TEXT NOT NULL,
    locale VARCHAR(10) NOT NULL DEFAULT 'en',
    created_at DATETIME NOT NULL
);

CREATE TABLE newsletter_subscriptions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    locale VARCHAR(10) NOT NULL DEFAULT 'en',
    source_path VARCHAR(255) DEFAULT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE operation_logs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    admin_id INT UNSIGNED DEFAULT NULL,
    action VARCHAR(50) NOT NULL,
    module VARCHAR(80) NOT NULL,
    entity_id INT UNSIGNED DEFAULT NULL,
    summary VARCHAR(255) DEFAULT NULL,
    ip_address VARCHAR(50) DEFAULT NULL,
    created_at DATETIME NOT NULL
);
