INSERT INTO site_settings (locale, setting_key, setting_value, updated_at) VALUES
('en', 'lookup_insurance_label', 'Insurance', NOW()),
('en', 'services_filter_label', 'Products & Services', NOW()),
('en', 'services_fourth_home_title', 'General Sales & Service Agent', NOW()),
('es', 'lookup_insurance_label', 'Insurance', NOW()),
('es', 'services_filter_label', 'Products & Services', NOW()),
('es', 'services_fourth_home_title', 'General Sales & Service Agent', NOW()),
('zh', 'lookup_insurance_label', 'Insurance', NOW()),
('zh', 'services_filter_label', 'Products & Services', NOW()),
('zh', 'services_fourth_home_title', 'General Sales & Service Agent', NOW())
ON DUPLICATE KEY UPDATE
setting_value = VALUES(setting_value),
updated_at = NOW();
