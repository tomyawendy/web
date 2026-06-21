-- Planet Aviation Spanish alignment cleanup
-- Keeps English as the visual/content baseline and normalizes Spanish copy.

INSERT INTO site_settings (locale, setting_key, setting_value, updated_at) VALUES
('es', 'site_meta_keywords', 'aviación, carga aérea, logística, GSSA', NOW()),
('es', 'site_meta_description', 'Planet Aviation ofrece soluciones de carga aérea, GSSA, logística, handling, transporte terrestre y seguros.', NOW()),
('es', 'homepage_meta_title', 'Soluciones premium para logística aérea', NOW()),
('es', 'homepage_meta_keywords', 'logística aérea, carga aérea, GSSA, transitarios', NOW()),
('es', 'homepage_meta_description', 'Especialistas en operaciones de carga aérea en Europa, Asia, Oriente Medio y América Latina.', NOW()),
('es', 'nav_quote_label', 'PEDIR COTIZACIÓN', NOW()),
('es', 'homepage_title', 'Soluciones premium\npara logística aérea', NOW()),
('es', 'homepage_subtitle', 'Especialistas en operaciones de carga aérea en Europa, Asia, Oriente Medio y América Latina.', NOW()),
('es', 'hero_button_text', 'SABER MÁS', NOW()),
('es', 'lookup_label', 'Estoy buscando', NOW()),
('es', 'lookup_insurance_label', 'Seguros', NOW()),
('es', 'home_about_heading', 'Su socio líder en ventas y servicios de carga aérea', NOW()),
('es', 'home_about_body', 'PLANET AVIATION, S.L. es un Agente General de Ventas y Servicios (GSSA) reconocido a nivel global, con sede en Europa. Conectamos necesidades logísticas complejas con una ejecución ágil y eficiente, mediante un modelo de servicio basado en comercialización, tecnología, soluciones y sostenibilidad.', NOW()),
('es', 'home_about_button', 'SABER MÁS', NOW()),
('es', 'services_heading', 'Excelencia en cada servicio', NOW()),
('es', 'services_intro', 'Planet Aviation ofrece una cartera integral de productos y servicios de carga aérea. Cada envío se gestiona con precisión, cuidado y profesionalidad, garantizando fiabilidad en cada etapa de la cadena logística.', NOW()),
('es', 'services_learn_more_label', 'SABER MÁS', NOW()),
('es', 'services_impact_label', 'Nuestro impacto', NOW()),
('es', 'services_kicker_label', 'Ver todo', NOW()),
('es', 'services_filter_label', 'Productos y servicios', NOW()),
('es', 'why_heading', 'Por qué nos eligen', NOW()),
('es', 'why_items', 'GSSA independiente\nSólida base financiera\nMarketing digital\nEquipos motivados y experimentados\nInteligencia comercial\nServicio integral: de ventas a facturación', NOW()),
('es', 'world_kicker_label', 'GESTIÓN GLOBAL. EXPERIENCIA LOCAL.', NOW()),
('es', 'world_heading', 'Un solo mundo', NOW()),
('es', 'world_intro', 'Gestión global con experiencia local en América, Europa, Oriente Medio, África y Asia-Pacífico.', NOW()),
('es', 'world_regions', 'Américas\nEuropa\nOriente Medio\nÁfrica\nAsia-Pacífico', NOW()),
('es', 'world_map_image', 'assets/figma/world-map.png', NOW()),
('es', 'stats_offices_label', 'Socios globales', NOW()),
('es', 'stats_support_label', 'Equipo de respuesta rápida', NOW()),
('es', 'stats_shipments_label', 'Transitarios', NOW()),
('es', 'partners_heading', 'Nuestros socios', NOW()),
('es', 'partners_subtitle', 'Estos son nuestros colaboradores', NOW()),
('es', 'news_kicker_label', 'NOTICIAS', NOW()),
('es', 'news_heading', 'Últimas noticias', NOW()),
('es', 'news_view_all_label', 'VER TODOS', NOW()),
('es', 'read_more_label', 'LEER MÁS', NOW()),
('es', 'contact_visual_image', 'assets/figma/contact-photo.png', NOW()),
('es', 'contact_phone', '+34 000 000 000', NOW()),
('es', 'contact_email', 'ops@planetaviation.com', NOW()),
('es', 'office_address', 'Madrid, España', NOW()),
('es', 'contact_kicker_label', 'CONTACTO', NOW()),
('es', 'contact_heading', 'Contacto', NOW()),
('es', 'contact_intro', 'Si necesita más información sobre nuestros servicios, complete el formulario. Nuestro equipo se pondrá en contacto con usted lo antes posible.', NOW()),
('es', 'newsletter_kicker_label', 'BOLETÍN', NOW()),
('es', 'newsletter_title', 'Suscríbase al boletín Logistics Pulse', NOW()),
('es', 'newsletter_body', 'Reciba nuestros insights directamente en su correo al suscribirse a este formulario y entre en un mundo de logística verdaderamente integrada. Inspírese con nuestra selección de artículos, que le ayudan a navegar las cadenas de suministro, comprender las tendencias del sector y definir su estrategia logística.', NOW()),
('es', 'newsletter_placeholder', 'Introduzca su correo electrónico', NOW()),
('es', 'footer_certification_label', 'Obtener certificación IATA', NOW()),
('es', 'footer_copyright', 'Copyright (c) Planet Aviation. Todos los derechos reservados.', NOW())
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = VALUES(updated_at);

UPDATE service_translations st
JOIN services s ON s.id = st.service_id
SET st.title = CASE s.slug
        WHEN 'general-sales-service-agent' THEN 'Agente General de Ventas y Servicios'
        WHEN 'air-cargo-consolidation-experts' THEN 'Expertos en consolidación de carga aérea'
        WHEN 'handling-trucking' THEN 'Handling y transporte terrestre'
        WHEN 'insurance-solutions' THEN 'Soluciones de seguro'
        ELSE st.title
    END,
    st.summary = CASE s.slug
        WHEN 'general-sales-service-agent' THEN 'Especialistas en operaciones de carga aérea en Europa, Asia, Oriente Medio y América Latina.'
        WHEN 'air-cargo-consolidation-experts' THEN 'Optimización estratégica de capacidad y soluciones rápidas de consolidación.'
        WHEN 'handling-trucking' THEN 'Soluciones coordinadas para handling aeroportuario, transporte terrestre y soporte operativo.'
        WHEN 'insurance-solutions' THEN 'Coberturas de seguro de carga para socios logísticos y operaciones aéreas.'
        ELSE st.summary
    END,
    st.content = CASE s.slug
        WHEN 'general-sales-service-agent' THEN '<ul><li>Representación comercial integral para aerolíneas asociadas</li><li>Asignación dinámica de capacidad para optimizar rendimiento e ingresos</li><li>Seguimiento comercial orientado a superar objetivos de venta</li></ul>'
        WHEN 'air-cargo-consolidation-experts' THEN '<ul><li>Optimización estratégica de capacidad para maximizar el rendimiento cúbico</li><li>Gestión precisa de rutas y utilización de espacios</li><li>Ajustes dinámicos de carga según la demanda operativa</li><li>Soluciones ágiles de consolidación aérea</li></ul>'
        WHEN 'handling-trucking' THEN '<ul><li>Handling aeroportuario con alto nivel de servicio</li><li>Soluciones competitivas de transporte terrestre</li><li>Soporte administrativo para importaciones y coordinación operativa</li></ul>'
        WHEN 'insurance-solutions' THEN '<ul><li>Cobertura global para distintos tipos de envío</li><li>Opciones flexibles adaptadas a cada operación</li><li>Gestión ágil de reclamaciones y prevención de riesgos</li></ul>'
        ELSE st.content
    END
WHERE st.locale = 'es';

UPDATE post_translations pt
JOIN posts p ON p.id = pt.post_id
SET pt.title = CASE p.slug
        WHEN 'planet-aviation-expands-regional-network' THEN 'Planet Aviation amplía su soporte regional'
        WHEN 'transport-logistic-air-cargo-europe' THEN 'Transport Logistic & Air Cargo Europe 2025'
        WHEN 'air-cargo-market-analysis' THEN 'Análisis del mercado de carga aérea 2026: la transformación'
        ELSE pt.title
    END,
    pt.excerpt = CASE p.slug
        WHEN 'planet-aviation-expands-regional-network' THEN 'Un nuevo marco operativo mejora la coordinación y la velocidad de respuesta para socios.'
        WHEN 'transport-logistic-air-cargo-europe' THEN 'Puntos clave de uno de los principales eventos europeos de logística y carga aérea.'
        WHEN 'air-cargo-market-analysis' THEN 'Un análisis reciente muestra cambios de rutas y demanda en el mercado de carga aérea.'
        ELSE pt.excerpt
    END
WHERE pt.locale = 'es';
