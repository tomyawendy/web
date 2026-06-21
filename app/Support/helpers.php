<?php

declare(strict_types=1);

function base_path(string $path = ''): string
{
    $base = dirname(__DIR__, 2);
    return $path ? $base . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path) : $base;
}

if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool
    {
        return $needle === '' || strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        return $needle === '' || strpos($haystack, $needle) !== false;
    }
}

function config(string $key, $default = null)
{
    static $config = [];

    [$file, $nested] = array_pad(explode('.', $key, 2), 2, null);

    if (!isset($config[$file])) {
        $path = base_path("config/{$file}.php");
        $config[$file] = file_exists($path) ? require $path : [];
    }

    if ($nested === null) {
        return $config[$file] ?: $default;
    }

    $value = $config[$file];
    foreach (explode('.', $nested) as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}

function app_url(string $path = ''): string
{
    $base = rtrim((string) config('app.url', ''), '/');
    $path = ltrim($path, '/');
    return $path ? "{$base}/{$path}" : $base;
}

function localized_url(string $path = '', ?string $locale = null): string
{
    $fragment = '';
    if (str_contains($path, '#')) {
        [$path, $fragment] = array_pad(explode('#', $path, 2), 2, '');
        $fragment = $fragment === '' ? '' : '#' . $fragment;
    }

    $locale ??= current_locale();
    $allowed = config('app.locales', []);
    $url = app_url($path);

    if (!isset($allowed[$locale])) {
        return $url . $fragment;
    }

    $separator = str_contains($url, '?') ? '&' : '?';
    return $url . $separator . 'lang=' . rawurlencode($locale) . $fragment;
}

function localized_current_url(?string $locale = null): string
{
    return localized_url(ltrim(request_path(), '/'), $locale);
}

function current_locale(): string
{
    return $_SESSION['locale'] ?? config('app.locale', 'en');
}

function set_locale(string $locale): void
{
    $allowed = config('app.locales', []);
    if (isset($allowed[$locale])) {
        $_SESSION['locale'] = $locale;
    }
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function asset_url(string $path): string
{
    return app_url('assets/' . ltrim($path, '/'));
}

function redirect_with_flash(string $url, string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    header('Location: ' . $url);
    exit;
}

function redirect_with_flash_data(string $url, array $flash): void
{
    $_SESSION['flash'] = $flash;
    header('Location: ' . $url);
    exit;
}

function flash(?string $key = null)
{
    $flash = $_SESSION['flash'] ?? null;
    if ($flash !== null) {
        unset($_SESSION['flash']);
    }

    if ($key === null || !is_array($flash)) {
        return $flash;
    }

    return $flash[$key] ?? null;
}

function peek_flash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    return is_array($flash) ? $flash : null;
}

function clear_flash(): void
{
    unset($_SESSION['flash']);
}

function old(string $key, $default = '')
{
    return $_SESSION['old'][$key] ?? $default;
}

function with_old(array $payload): void
{
    $_SESSION['old'] = $payload;
}

function clear_old(): void
{
    unset($_SESSION['old']);
}

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function verify_csrf(?string $token): bool
{
    return hash_equals($_SESSION['_csrf'] ?? '', (string) $token);
}

function admin_url(string $path = ''): string
{
    $prefix = trim((string) config('app.admin_prefix', 'admin'), '/');
    $path = ltrim($path, '/');
    return $path ? app_url($prefix . '/' . $path) : app_url($prefix);
}

function storage_path(string $path = ''): string
{
    $base = base_path('storage');
    return $path ? $base . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path) : $base;
}

function upload_path(string $path = ''): string
{
    $base = is_dir(base_path('assets'))
        ? base_path('assets/uploads')
        : (is_dir(base_path('htdocs'))
        ? base_path('htdocs/assets/uploads')
        : base_path('public/assets/uploads'));

    return $path ? $base . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : $base;
}

function locale_label(string $locale): string
{
    return config('app.locales.' . $locale, strtoupper($locale));
}

function status_options(): array
{
    return [
        'draft' => 'Draft',
        'published' => 'Published',
        'offline' => 'Offline',
        'archived' => 'Archived',
    ];
}

function translation_map(?array $item, string $key = 'translations'): array
{
    if (!$item || !isset($item[$key]) || !is_array($item[$key])) {
        return [];
    }

    $map = [];
    foreach ($item[$key] as $translation) {
        $map[$translation['locale']] = $translation;
    }

    return $map;
}

function translated_field(?array $item, string $locale, string $field, string $key = 'translations', string $default = ''): string
{
    $translations = translation_map($item, $key);
    return (string) ($translations[$locale][$field] ?? $default);
}

function resolved_translation(?array $item, ?string $locale = null, string $key = 'translations'): array
{
    $translations = translation_map($item, $key);
    if ($translations === []) {
        return [];
    }

    $locale ??= current_locale();
    $fallbackLocale = (string) config('app.locale', 'en');

    if (isset($translations[$locale]) && is_array($translations[$locale])) {
        return $translations[$locale];
    }

    if (isset($translations[$fallbackLocale]) && is_array($translations[$fallbackLocale])) {
        return $translations[$fallbackLocale];
    }

    $first = reset($translations);
    return is_array($first) ? $first : [];
}

function format_datetime(?string $value): string
{
    if (!$value) {
        return '-';
    }

    return date('Y-m-d H:i', strtotime($value));
}

function admin_user(): ?array
{
    return $_SESSION['admin'] ?? null;
}

function admin_can(string $permission): bool
{
    $user = admin_user();
    if (!$user) {
        return false;
    }

    if (($user['role_slug'] ?? '') === 'super-admin') {
        return true;
    }

    $permissions = $user['permissions'] ?? [];
    return is_array($permissions) && in_array($permission, $permissions, true);
}

function setting_value(array $settings, string $key, string $default = ''): string
{
    return (string) ($settings[$key] ?? $default);
}

function setting_lines(array $settings, string $key): array
{
    $raw = trim((string) ($settings[$key] ?? ''));
    if ($raw === '') {
        return [];
    }

    return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $raw) ?: [])));
}

function media_url(?string $path): string
{
    $path = trim((string) $path);
    if ($path === '') {
        return '';
    }

    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        return $path;
    }

    return app_url(ltrim($path, '/'));
}

function background_style(?string $path): string
{
    $url = media_url($path);
    return $url === '' ? '' : " style=\"background-image: url('" . e($url) . "');\"";
}

function raw_background_style(?string $path, string $prefix = ''): string
{
    $url = media_url($path);
    if ($url === '') {
        return '';
    }

    $background = $prefix === '' ? "url('" . e($url) . "')" : $prefix . ", url('" . e($url) . "')";
    return " style=\"background-image: {$background};\"";
}

function content_list_items(?string $html): array
{
    $html = trim((string) $html);
    if ($html === '') {
        return [];
    }

    preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $html, $matches);
    if (empty($matches[1])) {
        return [];
    }

    return array_values(array_filter(array_map(static function (string $item): string {
        return trim(html_entity_decode(strip_tags($item), ENT_QUOTES, 'UTF-8'));
    }, $matches[1])));
}

function setting_media_pairs(array $settings, string $key): array
{
    $rows = setting_lines($settings, $key);
    $items = [];

    foreach ($rows as $row) {
        [$label, $path] = array_pad(array_map('trim', explode('|', $row, 2)), 2, '');
        if ($label === '' && $path === '') {
            continue;
        }

        $items[] = [
            'label' => $label !== '' ? $label : basename($path),
            'path' => $path,
        ];
    }

    return $items;
}

function site_name(array $settings, string $default = 'Planet Aviation'): string
{
    return setting_value($settings, 'site_name', $default);
}

function site_meta_title(array $settings, string $pageTitle = '', string $defaultSiteName = 'Planet Aviation'): string
{
    $name = site_name($settings, $defaultSiteName);
    $pageTitle = trim($pageTitle);

    return $pageTitle === '' ? $name : $pageTitle . ' | ' . $name;
}

function public_settings_for_display(array $settings, ?string $locale = null): array
{
    $locale ??= current_locale();
    if ($locale !== 'es') {
        return $settings;
    }

    return array_merge($settings, [
        'site_meta_keywords' => 'aviación, carga aérea, logística, GSSA',
        'site_meta_description' => 'Planet Aviation ofrece soluciones de carga aérea, GSSA, logística, handling, transporte terrestre y seguros.',
        'homepage_meta_title' => 'Soluciones premium para logística aérea',
        'homepage_meta_keywords' => 'logística aérea, carga aérea, GSSA, transitarios',
        'homepage_meta_description' => 'Especialistas en operaciones de carga aérea en Europa, Asia, Oriente Medio y América Latina.',
        'nav_quote_label' => 'PEDIR COTIZACIÓN',
        'homepage_title' => "Soluciones premium\npara logística aérea",
        'homepage_subtitle' => 'Especialistas en operaciones de carga aérea en Europa, Asia, Oriente Medio y América Latina.',
        'hero_button_text' => 'SABER MÁS',
        'lookup_label' => 'Estoy buscando',
        'lookup_insurance_label' => 'Seguros',
        'home_about_heading' => 'Su socio líder en ventas y servicios de carga aérea',
        'home_about_body' => 'PLANET AVIATION, S.L. es un Agente General de Ventas y Servicios (GSSA) reconocido a nivel global, con sede en Europa. Conectamos necesidades logísticas complejas con una ejecución ágil y eficiente, mediante un modelo de servicio basado en comercialización, tecnología, soluciones y sostenibilidad.',
        'home_about_button' => 'SABER MÁS',
        'services_heading' => 'Excelencia en cada servicio',
        'services_intro' => 'Planet Aviation ofrece una cartera integral de productos y servicios de carga aérea. Cada envío se gestiona con precisión, cuidado y profesionalidad, garantizando fiabilidad en cada etapa de la cadena logística.',
        'services_learn_more_label' => 'SABER MÁS',
        'services_impact_label' => 'Nuestro impacto',
        'services_kicker_label' => 'Ver todo',
        'services_filter_label' => 'Productos y servicios',
        'why_items' => "GSSA independiente\nSólida base financiera\nMarketing digital\nEquipos motivados y experimentados\nInteligencia comercial\nServicio integral: de ventas a facturación",
        'world_kicker_label' => 'GESTIÓN GLOBAL. EXPERIENCIA LOCAL.',
        'world_heading' => 'Un solo mundo',
        'world_intro' => 'Gestión global con experiencia local en América, Europa, Oriente Medio, África y Asia-Pacífico.',
        'world_regions' => "Américas\nEuropa\nOriente Medio\nÁfrica\nAsia-Pacífico",
        'world_map_image' => 'assets/figma/world-map.png',
        'stats_offices_label' => 'Socios globales',
        'stats_support_label' => 'Equipo de respuesta rápida',
        'stats_shipments_label' => 'Transitarios',
        'partners_heading' => 'Nuestros socios',
        'partners_subtitle' => 'Estos son nuestros colaboradores',
        'news_kicker_label' => 'NOTICIAS',
        'news_heading' => 'Últimas noticias',
        'news_view_all_label' => 'VER TODOS',
        'read_more_label' => 'LEER MÁS',
        'contact_visual_image' => 'assets/figma/contact-photo.png',
        'contact_phone' => '+34 000 000 000',
        'contact_email' => 'ops@planetaviation.com',
        'office_address' => 'Madrid, España',
        'contact_kicker_label' => 'CONTACTO',
        'contact_heading' => 'Contacto',
        'contact_intro' => 'Si necesita más información sobre nuestros servicios, complete el formulario. Nuestro equipo se pondrá en contacto con usted lo antes posible.',
        'contact_name_label' => 'Nombre completo',
        'contact_phone_label' => 'Teléfono',
        'contact_email_label' => 'Correo electrónico',
        'contact_company_label' => 'Empresa',
        'contact_message_label' => 'Mensaje',
        'contact_submit_text' => 'ENVIAR',
        'newsletter_kicker_label' => 'BOLETÍN',
        'newsletter_title' => 'Suscríbase al boletín Logistics Pulse',
        'newsletter_body' => 'Reciba nuestros insights directamente en su correo al suscribirse a este formulario y entre en un mundo de logística verdaderamente integrada. Inspírese con nuestra selección de artículos, que le ayudan a navegar las cadenas de suministro, comprender las tendencias del sector y definir su estrategia logística.',
        'newsletter_placeholder' => 'Introduzca su correo electrónico',
        'newsletter_submit_text' => 'ENVIAR',
        'footer_certification_label' => 'Obtener certificación IATA',
        'footer_copyright' => 'Copyright (c) Planet Aviation. Todos los derechos reservados.',
        'back_to_insights_label' => 'VOLVER A NOTICIAS',
        'back_to_documents_label' => 'VOLVER A DOCUMENTOS',
    ]);
}

function public_services_for_display(array $services, ?string $locale = null): array
{
    return array_map(static fn (array $service): array => public_service_for_display($service, $locale), $services);
}

function public_service_for_display(array $service, ?string $locale = null): array
{
    $locale ??= current_locale();
    if ($locale !== 'es') {
        return $service;
    }

    $overrides = [
        'general-sales-service-agent' => [
            'title' => 'Agente General de Ventas y Servicios',
            'summary' => 'Especialistas en operaciones de carga aérea en Europa, Asia, Oriente Medio y América Latina.',
            'content' => '<ul><li>Representación comercial integral para aerolíneas asociadas</li><li>Asignación dinámica de capacidad para optimizar rendimiento e ingresos</li><li>Seguimiento comercial orientado a superar objetivos de venta</li></ul>',
            'seo_title' => 'Agente General de Ventas y Servicios',
            'seo_keywords' => 'GSSA, ventas de carga, carga aérea',
            'seo_description' => 'Representación GSSA completa para aerolíneas y socios de carga aérea.',
        ],
        'air-cargo-consolidation-experts' => [
            'title' => 'Expertos en consolidación de carga aérea',
            'summary' => 'Optimización estratégica de capacidad y soluciones rápidas de consolidación.',
            'content' => '<ul><li>Optimización estratégica de capacidad para maximizar el rendimiento cúbico</li><li>Gestión precisa de rutas y utilización de espacios</li><li>Ajustes dinámicos de carga según la demanda operativa</li><li>Soluciones ágiles de consolidación aérea</li></ul>',
            'seo_title' => 'Consolidación de carga aérea',
            'seo_keywords' => 'carga aérea, consolidación, capacidad',
            'seo_description' => 'Soluciones de consolidación y gestión de capacidad para operaciones de carga aérea.',
        ],
        'handling-trucking' => [
            'title' => 'Handling y transporte terrestre',
            'summary' => 'Soluciones coordinadas para handling aeroportuario, transporte terrestre y soporte operativo.',
            'content' => '<ul><li>Handling aeroportuario con alto nivel de servicio</li><li>Soluciones competitivas de transporte terrestre</li><li>Soporte administrativo para importaciones y coordinación operativa</li></ul>',
            'seo_title' => 'Handling y transporte terrestre',
            'seo_keywords' => 'handling, transporte terrestre, logística aérea',
            'seo_description' => 'Servicios de handling y transporte terrestre para operaciones logísticas aéreas.',
        ],
        'insurance-solutions' => [
            'title' => 'Soluciones de seguro',
            'summary' => 'Coberturas de seguro de carga para socios logísticos y operaciones aéreas.',
            'content' => '<ul><li>Cobertura global para distintos tipos de envío</li><li>Opciones flexibles adaptadas a cada operación</li><li>Gestión ágil de reclamaciones y prevención de riesgos</li></ul>',
            'seo_title' => 'Soluciones de seguro',
            'seo_keywords' => 'seguro de carga, logística, cobertura',
            'seo_description' => 'Soluciones de seguro para carga aérea y operaciones logísticas.',
        ],
    ];

    $slug = (string) ($service['slug'] ?? '');
    return isset($overrides[$slug]) ? array_merge($service, $overrides[$slug]) : $service;
}

function public_posts_for_display(array $posts, ?string $locale = null): array
{
    return array_map(static fn (array $post): array => public_post_for_display($post, $locale), $posts);
}

function public_post_for_display(array $post, ?string $locale = null): array
{
    $locale ??= current_locale();
    if ($locale !== 'es') {
        return $post;
    }

    $overrides = [
        'planet-aviation-expands-regional-network' => [
            'title' => 'Planet Aviation amplía su soporte regional',
            'excerpt' => 'Un nuevo marco operativo mejora la coordinación y la velocidad de respuesta para socios.',
            'content' => '<p>Planet Aviation ha ampliado su red operativa regional para agilizar solicitudes de soporte y mejorar la visibilidad de sus socios durante operaciones activas.</p>',
            'seo_title' => 'Planet Aviation amplía soporte regional',
            'seo_keywords' => 'Planet Aviation, red regional, carga aérea',
            'seo_description' => 'Actualización sobre la ampliación del soporte regional de Planet Aviation.',
        ],
        'transport-logistic-air-cargo-europe' => [
            'title' => 'Transport Logistic & Air Cargo Europe 2025',
            'excerpt' => 'Puntos clave de uno de los principales eventos europeos de logística y carga aérea.',
            'content' => '<p>La feria reunió a operadores, aerolíneas y socios logísticos para debatir capacidad, digitalización, servicio y nuevas oportunidades para el transporte aéreo de carga.</p>',
            'seo_title' => 'Transport Logistic & Air Cargo Europe 2025',
            'seo_keywords' => 'Transport Logistic, carga aérea, Europa',
            'seo_description' => 'Puntos destacados del evento europeo de logística y carga aérea.',
        ],
        'air-cargo-market-analysis' => [
            'title' => 'Análisis del mercado de carga aérea 2026: la transformación',
            'excerpt' => 'Un análisis reciente muestra cambios de rutas y demanda en el mercado de carga aérea.',
            'content' => '<p>Los nuevos datos del mercado muestran movimientos más marcados en corredores regionales de carga, impulsando estrategias más dinámicas de consolidación, capacidad y precios.</p>',
            'seo_title' => 'Análisis del mercado de carga aérea',
            'seo_keywords' => 'mercado de carga aérea, análisis, logística',
            'seo_description' => 'Análisis sobre tendencias y cambios de demanda en el mercado de carga aérea.',
        ],
    ];

    $slug = (string) ($post['slug'] ?? '');
    return isset($overrides[$slug]) ? array_merge($post, $overrides[$slug]) : $post;
}

function truncate_text(string $value, int $limit = 120, string $suffix = '...'): string
{
    if ($limit <= 0 || $value === '') {
        return '';
    }

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        return mb_strlen($value, 'UTF-8') > $limit
            ? mb_substr($value, 0, max(0, $limit - mb_strlen($suffix, 'UTF-8')), 'UTF-8') . $suffix
            : $value;
    }

    preg_match_all('/./us', $value, $chars);
    $chars = $chars[0] ?? [];
    if (count($chars) <= $limit) {
        return $value;
    }

    return implode('', array_slice($chars, 0, max(0, $limit - strlen($suffix)))) . $suffix;
}

function session_expired_message(): string
{
    return 'Your session expired. Please try again.';
}

function sign_in_required_message(): string
{
    return 'Please sign in to continue.';
}

function permission_denied_message(): string
{
    return 'You do not have permission to access this section.';
}

function password_required_message(): string
{
    return 'Please enter a password.';
}

function invalid_credentials_message(): string
{
    return 'Invalid username or password.';
}

function password_confirmation_message(): string
{
    return 'Password confirmation does not match.';
}

function account_not_found_message(): string
{
    return 'The account could not be found.';
}

function current_password_incorrect_message(): string
{
    return 'Current password is incorrect.';
}

function no_file_selected_message(): string
{
    return 'Please choose a file before uploading.';
}

function file_upload_failed_message(): string
{
    return 'The file could not be uploaded. Please try again.';
}

function unsupported_file_type_message(): string
{
    return 'This file type is not supported for the selected upload.';
}

function file_move_failed_message(): string
{
    return 'The file could not be saved. Please try again.';
}

function file_too_large_message(): string
{
    return 'This file is larger than the allowed upload size.';
}

function newsletter_email_required_message(): string
{
    return 'Please enter a valid email address.';
}

function newsletter_email_duplicate_message(): string
{
    return 'This email address is already subscribed.';
}

function newsletter_success_message(): string
{
    return 'Thank you for subscribing to our newsletter.';
}

function is_duplicate_key_error(\Throwable $exception): bool
{
    $code = (string) $exception->getCode();
    $message = $exception->getMessage();

    return $code === '23000'
        || str_contains($message, 'Integrity constraint violation')
        || str_contains($message, 'Duplicate entry');
}

function content_not_found_message(): string
{
    return 'The requested record could not be found.';
}

function normalize_post_type(?string $type): string
{
    return $type === 'document' ? 'document' : 'news';
}

function request_path(): string
{
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $basePath = parse_url((string) config('app.url', ''), PHP_URL_PATH) ?: '';
    if ($basePath !== '' && str_starts_with($uri, $basePath)) {
        $uri = substr($uri, strlen($basePath)) ?: '/';
    }

    return '/' . trim($uri, '/');
}

function normalize_return_path(?string $path, string $default = '/contact'): string
{
    $path = trim((string) $path);
    if ($path === '') {
        return $default;
    }

    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
        return $default;
    }

    if (!str_starts_with($path, '/')) {
        $path = '/' . ltrim($path, '/');
    }

    return preg_match('/^\/[A-Za-z0-9\-._~\/?#=&%]*$/', $path) === 1 ? $path : $default;
}
