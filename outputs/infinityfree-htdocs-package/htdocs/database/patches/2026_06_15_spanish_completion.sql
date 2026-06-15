-- Planet Aviation Spanish completion patch
-- Import after 2026_06_14_spanish_frontend.sql.

INSERT INTO site_settings (locale, setting_key, setting_value, updated_at) VALUES
('es', 'site_name', 'Planet Aviation', NOW()),
('es', 'hero_kicker', 'PLANET AVIATION, S.L.,', NOW()),
('es', 'contact_email', 'ops@planetaviation.com', NOW()),
('es', 'contact_phone', '', NOW()),
('es', 'office_address', 'Madrid, España', NOW()),
('es', 'contact_visual_image', 'assets/figma/contact-stage.png', NOW()),
('es', 'why_background_image', 'assets/figma/why-stage-full.png', NOW()),
('es', 'world_map_image', 'assets/figma/world-stage.png', NOW()),
('es', 'stats_offices', '100+', NOW()),
('es', 'stats_support', '24/7', NOW()),
('es', 'stats_shipments', '16,000+', NOW()),
('es', 'services_impact_label', 'Nuestro impacto', NOW()),
('es', 'contact_kicker_label', 'CONTACTO', NOW()),
('es', 'newsletter_kicker_label', 'BOLETÍN', NOW()),
('es', 'back_to_insights_label', 'VOLVER A NOTICIAS', NOW()),
('es', 'back_to_documents_label', 'VOLVER A DOCUMENTOS', NOW()),
('es', 'documents_intro', 'Documentos oficiales, avisos operativos y archivos descargables para consulta rápida.', NOW()),
('es', 'empty_insights_title', 'Aún no hay noticias publicadas.', NOW()),
('es', 'empty_insights_body', 'Cuando el contenido se publique en el CMS, aparecerá aquí automáticamente.', NOW()),
('es', 'empty_documents_title', 'Aún no hay documentos disponibles.', NOW()),
('es', 'empty_documents_body', 'Suba y publique documentos en el backend para que aparezcan aquí automáticamente.', NOW())
ON DUPLICATE KEY UPDATE
setting_value = VALUES(setting_value),
updated_at = VALUES(updated_at);

UPDATE site_settings SET setting_value = CASE setting_key
    WHEN 'nav_home_label' THEN 'Inicio'
    WHEN 'nav_about_label' THEN 'Quiénes somos'
    WHEN 'nav_services_label' THEN 'Servicios'
    WHEN 'nav_insights_label' THEN 'Noticias'
    WHEN 'nav_documents_label' THEN 'Documentos'
    WHEN 'nav_contact_label' THEN 'Contacto'
    WHEN 'homepage_title' THEN 'Soluciones premium\npara logística aérea!'
    WHEN 'homepage_subtitle' THEN 'Especialistas en operaciones de carga aérea en Europa, Asia, Oriente Medio y América Latina.'
    WHEN 'hero_button_text' THEN 'SABER MÁS'
    WHEN 'lookup_label' THEN 'Estoy buscando'
    WHEN 'home_about_button' THEN 'SABER MÁS'
    WHEN 'services_learn_more_label' THEN 'SABER MÁS'
    WHEN 'news_heading' THEN 'Últimas noticias'
    WHEN 'news_view_all_label' THEN 'VER TODOS'
    WHEN 'read_more_label' THEN 'LEER MÁS'
    WHEN 'download_attachment_label' THEN 'DESCARGAR DOCUMENTO'
    WHEN 'contact_intro' THEN 'Si necesita más información sobre nuestros servicios, complete el formulario. Nuestro equipo se pondrá en contacto con usted lo antes posible.'
    WHEN 'contact_phone_label' THEN 'Teléfono'
    WHEN 'contact_email_label' THEN 'Correo electrónico'
    WHEN 'newsletter_placeholder' THEN 'Introduzca su correo electrónico'
    WHEN 'footer_pages_title' THEN 'Páginas'
    WHEN 'footer_certification_label' THEN 'Obtener certificación IATA'
    WHEN 'footer_copyright' THEN 'Copyright (c) Planet Aviation. Todos los derechos reservados'
    ELSE setting_value
END
WHERE locale = 'es';
