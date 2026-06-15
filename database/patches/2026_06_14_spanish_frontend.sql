-- Planet Aviation Spanish frontend content patch
-- Import once after database/patches/2026_06_14_cms_operations.sql.
-- Default frontend language remains English. Spanish appears only after manual language switch.
-- Text is ASCII-safe to avoid mojibake in shared-hosting imports.

UPDATE page_translations SET
    title = 'Quienes somos',
    excerpt = 'PLANET AVIATION, S.L. es un Agente General de Ventas y Servicios reconocido internacionalmente y con sede en Europa.',
    content = '<p>PLANET AVIATION, S.L. es un Agente General de Ventas y Servicios (GSSA) reconocido internacionalmente y con sede en Europa. Conectamos necesidades logisticas complejas con una ejecucion clara, agil y confiable.</p><p>Nuestro modelo se apoya en cuatro pilares: comercializacion, tecnologia, soluciones y sostenibilidad. Gracias a nuestro conocimiento local del mercado, ayudamos a transitarios y socios a optimizar su rendimiento operativo y sus resultados comerciales.</p><p>Entendemos que el servicio aereo es una pieza clave de la seguridad de la cadena de suministro global. Por eso ofrecemos soluciones especializadas, coordinacion operativa y cobertura de riesgos para operaciones de carga aerea.</p>',
    seo_title = 'Quienes somos | Planet Aviation',
    seo_keywords = 'aviacion, GSSA, logistica aerea, carga aerea',
    seo_description = 'Conozca Planet Aviation, GSSA europeo especializado en soluciones de logistica aerea y carga internacional.'
WHERE locale = 'es' AND page_id = (SELECT id FROM pages WHERE slug = 'about' LIMIT 1);

UPDATE page_translations SET
    title = 'Contacto',
    excerpt = 'Si necesita mas informacion sobre nuestros servicios, complete el formulario y nuestro equipo se pondra en contacto con usted.',
    content = '<p>Comparta sus necesidades de ruta, programacion, documentacion o soporte operativo. Nuestro equipo respondera con rapidez.</p>',
    seo_title = 'Contacto | Planet Aviation',
    seo_keywords = 'contacto, carga aerea, logistica aerea',
    seo_description = 'Contacte con Planet Aviation para consultas sobre servicios de carga aerea, GSSA y soporte logistico.'
WHERE locale = 'es' AND page_id = (SELECT id FROM pages WHERE slug = 'contact' LIMIT 1);

UPDATE service_translations SET
    title = 'Agente General de Ventas y Servicios',
    summary = 'Especialistas en operaciones de carga aerea en Europa, Asia, Oriente Medio y America Latina.',
    content = '<ul><li>Representacion comercial integral para aerolineas asociadas</li><li>Asignacion dinamica de capacidad para optimizar rendimiento e ingresos</li><li>Seguimiento comercial orientado a superar objetivos de venta</li></ul>',
    seo_title = 'Agente General de Ventas y Servicios',
    seo_keywords = 'GSSA, ventas de carga, carga aerea',
    seo_description = 'Representacion GSSA completa para aerolineas y socios de carga aerea.'
WHERE locale = 'es' AND service_id = (SELECT id FROM services WHERE slug = 'general-sales-service-agent' LIMIT 1);

UPDATE service_translations SET
    title = 'Expertos en consolidacion de carga aerea',
    summary = 'Optimizacion estrategica de capacidad y soluciones rapidas de consolidacion.',
    content = '<ul><li>Optimizacion estrategica de capacidad para maximizar el rendimiento cubico</li><li>Gestion precisa de rutas y utilizacion de espacios</li><li>Ajustes dinamicos de carga segun la demanda operativa</li><li>Soluciones agiles de consolidacion aerea</li></ul>',
    seo_title = 'Consolidacion de carga aerea',
    seo_keywords = 'carga aerea, consolidacion, capacidad',
    seo_description = 'Soluciones de consolidacion y gestion de capacidad para operaciones de carga aerea.'
WHERE locale = 'es' AND service_id = (SELECT id FROM services WHERE slug = 'air-cargo-consolidation-experts' LIMIT 1);

UPDATE service_translations SET
    title = 'Handling y transporte terrestre',
    summary = 'Coordinacion de handling, administracion de importaciones y transporte terrestre eficiente.',
    content = '<ul><li>Handling aeroportuario con alto nivel de servicio</li><li>Soluciones competitivas de transporte terrestre</li><li>Soporte administrativo para importaciones y coordinacion operativa</li></ul>',
    seo_title = 'Handling y transporte terrestre',
    seo_keywords = 'handling, trucking, transporte terrestre',
    seo_description = 'Servicios de handling y transporte terrestre para operaciones logisticas aereas.'
WHERE locale = 'es' AND service_id = (SELECT id FROM services WHERE slug = 'handling-trucking' LIMIT 1);

UPDATE service_translations SET
    title = 'Soluciones de seguro',
    summary = 'Coberturas de seguro de carga para socios logisticos y operaciones aereas.',
    content = '<ul><li>Cobertura global para distintos tipos de envio</li><li>Opciones flexibles adaptadas a cada operacion</li><li>Gestion agil de reclamaciones y prevencion de riesgos</li></ul>',
    seo_title = 'Soluciones de seguro de carga',
    seo_keywords = 'seguro de carga, logistica, cobertura',
    seo_description = 'Soluciones de seguro de carga para socios logisticos y operaciones de transporte aereo.'
WHERE locale = 'es' AND service_id = (SELECT id FROM services WHERE slug = 'insurance-solutions' LIMIT 1);

UPDATE post_translations SET
    title = 'Planet Aviation amplia su soporte regional',
    excerpt = 'Un nuevo marco operativo mejora la coordinacion y la velocidad de respuesta para socios.',
    content = '<p>Planet Aviation ha ampliado su red operativa regional para agilizar solicitudes de soporte y mejorar la visibilidad de sus socios durante operaciones activas.</p>',
    seo_title = 'Planet Aviation amplia soporte regional',
    seo_keywords = 'Planet Aviation, red regional, carga aerea',
    seo_description = 'Actualizacion sobre la expansion del soporte regional de Planet Aviation.'
WHERE locale = 'es' AND post_id = (SELECT id FROM posts WHERE slug = 'planet-aviation-expands-regional-network' LIMIT 1);

UPDATE post_translations SET
    title = 'Analisis del mercado de carga aerea 2026',
    excerpt = 'Un analisis reciente muestra cambios de rutas y demanda en el mercado de carga aerea.',
    content = '<p>Los nuevos datos del mercado muestran movimientos mas marcados en corredores regionales de carga, impulsando estrategias mas dinamicas de consolidacion, capacidad y precios.</p>',
    seo_title = 'Analisis del mercado de carga aerea',
    seo_keywords = 'mercado de carga aerea, analisis, logistica',
    seo_description = 'Analisis sobre tendencias y cambios de demanda en el mercado de carga aerea.'
WHERE locale = 'es' AND post_id = (SELECT id FROM posts WHERE slug = 'air-cargo-market-analysis' LIMIT 1);

UPDATE post_translations SET
    title = 'Transport Logistic & Air Cargo Europe 2025',
    excerpt = 'Puntos clave de uno de los principales eventos europeos de logistica y carga aerea.',
    content = '<p>Planet Aviation revisa las tendencias operativas, estrategias de aerolineas y conversaciones con socios surgidas durante este importante evento del sector.</p>',
    seo_title = 'Transport Logistic Europe 2025',
    seo_keywords = 'Transport Logistic, carga aerea, Europa',
    seo_description = 'Resumen de tendencias del evento Transport Logistic & Air Cargo Europe.'
WHERE locale = 'es' AND post_id = (SELECT id FROM posts WHERE slug = 'transport-logistic-air-cargo-europe' LIMIT 1);

UPDATE post_translations SET
    title = 'Nueva lista de documentacion para operaciones de verano',
    excerpt = 'Se recomienda un paquete estandar de documentos para solicitudes de soporte charter.',
    content = '<p>El equipo operativo recomienda una lista estandar que incluye permisos, coordinacion de handling, manifiestos y slots aeroportuarios para operaciones de verano.</p>',
    seo_title = 'Lista de documentacion operativa',
    seo_keywords = 'documentacion, operaciones, carga aerea',
    seo_description = 'Actualizacion sobre documentacion recomendada para operaciones de verano.'
WHERE locale = 'es' AND post_id = (SELECT id FROM posts WHERE slug = 'new-documentation-checklist-for-summer-operations' LIMIT 1);

UPDATE banner_translations SET
    title = 'Soluciones premium para logistica aerea',
    subtitle = 'Especialistas en operaciones de carga aerea en Europa, Asia, Oriente Medio y America Latina.',
    button_text = 'SABER MAS'
WHERE locale = 'es';

UPDATE site_settings SET setting_value = CASE setting_key
    WHEN 'site_meta_title' THEN 'Planet Aviation'
    WHEN 'site_meta_keywords' THEN 'aviacion, carga aerea, logistica, GSSA'
    WHEN 'site_meta_description' THEN 'Planet Aviation ofrece soluciones de carga aerea, GSSA, logistica, handling, transporte terrestre y seguros.'
    WHEN 'site_og_image' THEN 'assets/figma/hero-plane.png'
    WHEN 'homepage_meta_title' THEN 'Soluciones premium para logistica aerea'
    WHEN 'homepage_meta_keywords' THEN 'logistica aerea, carga aerea, GSSA, transitarios'
    WHEN 'homepage_meta_description' THEN 'Especialistas en operaciones de carga aerea en Europa, Asia, Oriente Medio y America Latina.'
    WHEN 'homepage_og_image' THEN 'assets/figma/hero-plane.png'
    WHEN 'nav_home_label' THEN 'Inicio'
    WHEN 'nav_about_label' THEN 'Quienes somos'
    WHEN 'nav_services_label' THEN 'Servicios'
    WHEN 'nav_insights_label' THEN 'Noticias'
    WHEN 'nav_documents_label' THEN 'Documentos'
    WHEN 'nav_contact_label' THEN 'Contacto'
    WHEN 'nav_quote_label' THEN 'COTIZAR'
    WHEN 'homepage_title' THEN 'Soluciones premium\npara logistica aerea'
    WHEN 'homepage_subtitle' THEN 'Especialistas en operaciones de carga aerea en Europa, Asia, Oriente Medio y America Latina.'
    WHEN 'hero_button_text' THEN 'SABER MAS'
    WHEN 'lookup_label' THEN 'Estoy buscando'
    WHEN 'lookup_insurance_label' THEN 'Seguros'
    WHEN 'home_about_heading' THEN 'Su socio lider en ventas y servicios de carga aerea'
    WHEN 'home_about_body' THEN 'PLANET AVIATION, S.L. es un GSSA con sede en Europa, especializado en conectar necesidades logisticas complejas con una ejecucion eficiente, clara y confiable.'
    WHEN 'home_about_button' THEN 'SABER MAS'
    WHEN 'services_kicker_label' THEN 'Ver todo'
    WHEN 'services_filter_label' THEN 'Productos y servicios'
    WHEN 'services_heading' THEN 'Excelencia en cada servicio'
    WHEN 'services_intro' THEN 'Planet Aviation ofrece una cartera integral de productos y servicios de carga aerea, gestionando cada envio con precision, cuidado y profesionalidad.'
    WHEN 'services_fourth_home_title' THEN 'Agente General de Ventas y Servicios'
    WHEN 'services_learn_more_label' THEN 'SABER MAS'
    WHEN 'why_heading' THEN 'Por que nos eligen'
    WHEN 'world_kicker_label' THEN 'GESTION GLOBAL. EXPERIENCIA LOCAL.'
    WHEN 'why_items' THEN 'GSSA independiente\nSolida base financiera\nMarketing digital\nEquipos motivados y experimentados\nInteligencia comercial\nServicio integral: de ventas a facturacion'
    WHEN 'world_heading' THEN 'Un solo mundo'
    WHEN 'world_intro' THEN 'Gestion global con experiencia local en America, Europa, Oriente Medio, Africa y Asia Pacifico.'
    WHEN 'world_regions' THEN 'America\nEuropa\nOriente Medio\nAfrica\nAsia Pacifico'
    WHEN 'stats_offices_label' THEN 'Socios globales'
    WHEN 'stats_support_label' THEN 'Equipo de respuesta rapida'
    WHEN 'stats_shipments_label' THEN 'Transitarios'
    WHEN 'partners_heading' THEN 'Nuestros socios'
    WHEN 'partners_subtitle' THEN 'Colaboradores que impulsan nuestra red'
    WHEN 'news_kicker_label' THEN 'NOTICIAS'
    WHEN 'news_heading' THEN 'Ultimas noticias'
    WHEN 'news_view_all_label' THEN 'VER TODOS'
    WHEN 'read_more_label' THEN 'LEER MAS'
    WHEN 'download_attachment_label' THEN 'DESCARGAR DOCUMENTO'
    WHEN 'contact_heading' THEN 'Contacto'
    WHEN 'contact_intro' THEN 'Si necesita mas informacion sobre nuestros servicios, complete el formulario. Nuestro equipo de expertos se pondra en contacto con usted lo antes posible.'
    WHEN 'contact_name_label' THEN 'Nombre completo'
    WHEN 'contact_phone_label' THEN 'Telefono'
    WHEN 'contact_email_label' THEN 'Correo electronico'
    WHEN 'contact_company_label' THEN 'Empresa'
    WHEN 'contact_message_label' THEN 'Mensaje'
    WHEN 'contact_submit_text' THEN 'ENVIAR'
    WHEN 'newsletter_title' THEN 'Suscribase al boletin Logistics Pulse'
    WHEN 'newsletter_body' THEN 'Reciba nuestras novedades directamente en su correo y descubra contenidos que le ayudan a entender tendencias, cadenas de suministro y estrategia logistica.'
    WHEN 'newsletter_placeholder' THEN 'Introduzca su correo electronico'
    WHEN 'newsletter_submit_text' THEN 'ENVIAR'
    WHEN 'footer_pages_title' THEN 'Paginas'
    WHEN 'footer_services_title' THEN 'Servicios'
    WHEN 'footer_about_title' THEN 'Acerca de'
    WHEN 'footer_events_label' THEN 'Eventos'
    WHEN 'footer_awards_label' THEN 'Reconocimientos'
    WHEN 'footer_contact_label' THEN 'Contacto'
    WHEN 'footer_news_label' THEN 'Noticias'
    WHEN 'footer_certification_label' THEN 'Obtener certificacion IATA'
    WHEN 'footer_copyright' THEN 'Copyright (c) Planet Aviation. Todos los derechos reservados'
    WHEN 'page_not_found_message' THEN 'La pagina solicitada no esta disponible.'
    WHEN 'service_not_found_message' THEN 'El servicio solicitado no esta disponible.'
    WHEN 'post_not_found_message' THEN 'El contenido solicitado no esta disponible.'
    WHEN 'contact_error_invalid' THEN 'Su sesion ha caducado. Intentelo de nuevo.'
    WHEN 'contact_error_required' THEN 'Nombre, correo electronico y mensaje son obligatorios.'
    WHEN 'contact_success_message' THEN 'Su solicitud ha sido enviada.'
    WHEN 'newsletter_error_required' THEN 'Introduzca un correo electronico valido.'
    WHEN 'newsletter_error_duplicate' THEN 'Este correo electronico ya esta suscrito.'
    WHEN 'newsletter_success_message' THEN 'Gracias por suscribirse a nuestro boletin.'
    ELSE setting_value
END
WHERE locale = 'es';
