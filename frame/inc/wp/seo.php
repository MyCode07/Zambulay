<?php

/**
 * SEO-обвязка лендинга (2026-08-03): хелперы медиа, чистка head,
 * defer скриптов, микроразметка FAQPage/SoftwareApplication/Organization.
 */

// ---------------------------------------------------------------------------
// Хелперы медиа: у ACF-картинок размеры лежат прямо в массиве, у видео —
// только в метаданных вложения. Без width/height страница ловит CLS 0.44.
// ---------------------------------------------------------------------------

function media_dims($media)
{
    if (!is_array($media)) {
        return '';
    }
    $w = !empty($media['width']) ? (int) $media['width'] : 0;
    $h = !empty($media['height']) ? (int) $media['height'] : 0;
    if ((!$w || !$h) && !empty($media['ID'])) {
        $meta = wp_get_attachment_metadata($media['ID']);
        $w = !empty($meta['width']) ? (int) $meta['width'] : 0;
        $h = !empty($meta['height']) ? (int) $meta['height'] : 0;
    }
    return ($w && $h) ? ' width="' . $w . '" height="' . $h . '"' : '';
}

// ---------------------------------------------------------------------------
// Чистка <head>: ссылка на /comments/feed/ вела на 404 прямо с главной,
// REST/oEmbed-дискавери и shortlink индексации не нужны.
// ---------------------------------------------------------------------------

remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('template_redirect', 'rest_output_link_header', 11);
remove_action('template_redirect', 'wp_shortlink_header', 11);

// ---------------------------------------------------------------------------
// defer: скрипты и так в конце body, но без defer их парсинг блокирует
// главный поток до интерактивности (TBT). Порядок среди defer сохраняется.
// ---------------------------------------------------------------------------

add_filter('script_loader_tag', function ($tag, $handle) {
    $defer = array('jquery', 'app', 'ajax', 'script', 'cookies', 'blank-sheet-navigation');
    if (in_array($handle, $defer, true) && strpos($tag, ' defer') === false && strpos($tag, ' async') === false) {
        $tag = str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
}, 10, 2);
