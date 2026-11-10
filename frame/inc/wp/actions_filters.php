<?php

// Author profiles are not public, including feeds and ?author=ID URLs.
add_action('template_redirect', 'frame_disable_author_archives', 0);
function frame_disable_author_archives()
{
    if (!is_author()) {
        return;
    }

    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    nocache_headers();
    remove_action('template_redirect', 'redirect_canonical');
}

// Keep disabled author URLs out of WordPress and Yoast sitemaps.
add_filter('wp_sitemaps_add_provider', static function ($provider, $name) {
    return $name === 'users' ? false : $provider;
}, 10, 2);
add_filter('wpseo_sitemap_exclude_author', '__return_empty_array');

// remove body svg
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');


// menu
add_filter('nav_menu_css_class', 'nav_css_filter');
function nav_css_filter($classes)
{
    return $classes = [];
}


// remove  archive title prefix
add_filter('get_the_archive_title_prefix', '__return_empty_string');


add_filter('wp_title', 'decode_html_chars', 10, 3);
function decode_html_chars($title, $sep, $seplocation)
{
    return wp_specialchars_decode($title, ENT_QUOTES);
}

add_filter('the_title', 'specialchars_decode');
function specialchars_decode($title)
{
    return wp_specialchars_decode($title, ENT_QUOTES);
}


add_filter('the_title', 'remove_nbsp');
function remove_nbsp($title)
{
    $title = str_replace('&nbsp;',  '', $title);
    $title = str_replace('/\s+/', ' ', $title);
    $title = preg_replace('~\x{00a0}~siu', ' ', $title);
    return $title;
}


// Применяем фильтры сразу для вывода контента, заголовков и цитат
add_filter('the_content', 'fix_all_short_words');
// add_filter('the_title', 'fix_all_short_words');
add_filter('get_the_excerpt', 'fix_all_short_words');
add_filter('widget_text', 'fix_all_short_words');
function fix_all_short_words($text)
{
    if (empty($text)) return $text;

    // Регулярное выражение находит любые слова длиной 1 или 2 буквы (\p{L}{1,2})
    // перед которыми есть пробел или начало строки, и заменяет следующий за ними пробел на &nbsp;
    $pattern = '/(?<=\s|^)(\p{L}{1,2})\s+(?=\p{L})/ui';
    $parts = wp_html_split($text);
    $protected = [];
    foreach ($parts as &$part) {
        if (str_starts_with($part, '<')) {
            // Preserve code and raw-text elements as well as HTML attributes.
            if (preg_match('~^<(/?)(script|style|pre|code|textarea)\b~i', $part, $tag)) {
                $name = strtolower($tag[2]);
                if ($tag[1] === '/') {
                    if (end($protected) === $name) array_pop($protected);
                } else {
                    $protected[] = $name;
                }
            }
            continue;
        }
        if ($protected) continue;
        $part = preg_replace($pattern, '$1&nbsp;', $part);
        $part = preg_replace('/\s+([—–-])\s+/u', '&nbsp;$1 ', $part);
    }
    unset($part);

    return implode('', $parts);
}


// Добавляем таблицы
add_filter('mce_buttons_2', function ($buttons) {
    $buttons[] = 'table';
    return $buttons;
});

// Подключаем модуль таблиц TinyMCE.
add_filter('mce_external_plugins', function ($plugins) {
    $plugins['table'] = get_theme_file_uri('dist/files/tinymce/table.min.js');

    return $plugins;
});

// Настройки таблиц.
add_filter('tiny_mce_before_init', function ($init) {
    $init['table_default_attributes'] = json_encode([
        'class' => 'editor-table',
    ]);

    $init['table_default_styles'] = '{}';

    return $init;
});


add_filter('big_image_size_threshold', '__return_false');