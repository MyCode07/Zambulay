<?php

function pre($obj)
{
    echo '<pre>';
    print_r($obj);
    echo '</pre>';
}

function frame_is_vite_dev(): bool
{
    return wp_get_environment_type() === 'local'
        && defined('WP_VITE_DEV')
        && WP_VITE_DEV === true;
}

function frame_asset(string $path): string
{
    $path = ltrim($path, '/');

    // The generated sprite lives in dist, including in the local environment.
    $assetPath = substr($path, 0, strcspn($path, '?#'));
    if ($assetPath === 'img/svg/icons.svg') {
        return get_theme_file_uri('dist/' . $path);
    }

    if (frame_is_vite_dev()) {
        return 'http://localhost:4040/' . $path;
    }

    return get_theme_file_uri('dist/' . $path);
}




// phone link
function get_phone_link($phone)
{
    if (!$phone) return;

    $phone_link = preg_replace('/[^0-9]/', '', $phone);
    $phone_link = substr($phone_link, 1);
    $phone_link = 'tel:+7' . $phone_link;
    return $phone_link;
}


// get ,emu by location + polylang
function get_locate_menu($location = 'primary')
{
    $menu_args = [
        'theme_location' => $location,
        'container'       => 'nav',
        'container_class' => '',
        'menu_class'      => '',
        'items_wrap'      => '<ul>%3$s</ul>',
    ];
    return wp_nav_menu($menu_args);
}



// custom menu
function get_custom_menu($name, $ul = true, $menu = false)
{


    if (function_exists('pll_current_language')) {
        $default = pll_default_language();
        $current = pll_current_language();

        if ($current !== $default) {
            $name = $name . ' ' . $current;
        }
    }

    if ($ul) {
        $menu_args = [
            'menu'  => $name,
            'container'       => '',
            'container_class' => '',
            'menu_class'      => '',
            'items_wrap'      => '<ul>%3$s</ul>',
            'fallback_cb'     => '',
            'walker' => $menu ? new Custom_Menu_Walker() : false,
        ];
    } else {
        $menu_args = [
            'menu'  => $name,
            'container'       => '',
            'container_class' => '',
            'menu_class'      => '',
            'items_wrap'      => '%3$s',
            'fallback_cb'     => '',
            'walker' => $menu ? new Custom_Menu_Walker() : false,
        ];
    }

    return wp_nav_menu($menu_args);
}

class Custom_Menu_Walker extends Walker_Nav_Menu
{
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $output .= '<li data-animate-menu>';

        $output .= sprintf(
            '<a href="%s">%s</a>',
            esc_url($item->url),
            esc_html($item->title)
        );
    }

    public function end_el(&$output, $item, $depth = 0, $args = null)
    {
        $output .= '</li>';
    }
}

// logo url
function get_logo_url()
{
    $custom_logo__url = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
    return $custom_logo__url[0];
}



// get link text and url
function get_link_info($link, $class = '', $attrs = '')
{
    if (!$link || !$link['url']) return;

    $link_url = $link['url'];
    $link_text = $link['title'];
    $link_target = $link['target'];

    $rel = '';
    if ($link_target == '_blank') {
        $rel = 'rel="nofollow"';
    }

    $svg = '';
    if (in_array('menu-btn', preg_split('/\s+/', trim($class)), true)) {
        $svg = '<svg width="13" height="10" viewBox="0 0 13 10">
                    <use xlink:href="' . esc_url(frame_asset('img/svg/icons.svg#menu-btn-arrow')) . '" />
                </svg>';
    }


    return '<a href="' . $link_url . '" target="' . $link_target . '" ' . $rel . ' class="' . $class . '" ' . $attrs . ' >' . $link_text . $svg . '</a>';
}

// get link text and url with icon
function get_link_with_icon_info($link, $class, $svg = false)
{
    if ($link) {
        $link_url = $link['url'];
        $link_text = $link['title'];
        $link_target = $link['target'];
    } else {
        $link_url = '#';
        $link_text = '';
        $link_target = '_blank';
    }

    $icon = '<svg viewBox="0 0 13 10"><use xlink:href="' . esc_url(frame_asset('img/svg/icons.svg#menu-btn-arrow')) . '"></use></svg>';
    if (!$link_target) {
        $icon = '';
    }

    return '<a href="' . $link_url . '" target="' . $link_target . '" class="' . $class . '">
                    <span>' . $link_text . '</span>
                    ' . $icon . '
                </a>';
}



// get custom posts
function get_posts_custom($args)
{
    if (!$args) return;

    $query_args = array(
        'post_type' => $args['post_type'] ?? 'post',
        'post_status' => $args['post_status'] ?? 'publish',
        'posts_per_page' => $args['count'] ?? null,
        'numberposts' => $args['count'] ?? null,
        'page' =>  $args['page'] ?? null,
        'post_parent' => $args['post_parent'] ?? null,
        'post__in' => $args['post__in'] ?? null,
        'tax_query' =>  $args['tax_query'] ?? null,
        'meta_query' =>  $args['meta_query'] ??  null,
        'orderby' =>  $args['orderby'] ?? null,
        'order' =>  $args['order'] ?? null,
        'no_found_rows'  => true,
        'suppress_filters'  => false,
    );

    $count = 1;
    $query = new WP_Query($query_args);
    $found_posts = '';

    $template = $args['template'] ?? ($args['post_type'] ?? 'post');
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            if (isset($args['exclude']) && $args['exclude'] == get_the_ID()) {
                continue;
            }

            ob_start();
            get_template_part('template-parts/post-cards/' . $template, null, array('count' => $count));
            $content = ob_get_clean();

            if (isset($args['slide']) && $args['slide']) {
                $found_posts .= '<div class="swiper-slide">';
            }
            $found_posts .= $content;
            if (isset($args['slide']) && $args['slide']) {
                $found_posts .= '</div>';
            }
            $count++;
        }
        wp_reset_postdata();
    } else {
        $found_posts = '<div class="_nothing">Ничего не найдено</div>';
    }

    return $found_posts;
}



// check posts count
function check_posts_count($post_type, $count = 3)
{
    $query = new WP_Query(array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'numberposts' => -1,
    ));

    $found_posts = $query->found_posts;

    if (!$found_posts) return false;

    if ($found_posts <= $count) return false;
    else return true;
}


// archive navigation
function my_pagenavi()
{
    global $wp_query;

    $prev = '<span>Назад</span>';
    $next = '<span>Вперед</span>';

    $args = array(
        'type'    => 'list',
        'current' => max(1, get_query_var('paged')),
        'total'   => $wp_query->max_num_pages,
        'prev_text'    => $prev,
        'next_text'    => $next,
        'show_all'     => false,
        'add_args'  => array(),
    );


    $result = paginate_links($args);

    // удаляем добавку к пагинации для первой страницы
    $result = preg_replace('~/page/1/?([\'"])~', '', $result);

    return $result;
}


// Выводит обрезанный excerpt с проверкой длины.
function get_loop_custom_excerpt($post = null, $limit = 12, $more = '...')
{
    // get_post() не делает запросов к БД, если пост уже в памяти (кэширован циклом)
    $post = get_post($post);

    if (! $post) {
        return '';
    }

    if (! empty($post->post_excerpt)) {
        $text = $post->post_excerpt;
    } else {
        $text = $post->post_content;
    }

    $text = strip_shortcodes($text);
    if (function_exists('excerpt_remove_blocks')) {
        $text = excerpt_remove_blocks($text);
    }
    $text = wp_strip_all_tags($text);

    return wp_trim_words($text, $limit, $more);
}

// first sentece
function get_first_sentence($str)
{
    if (!$str) return;
    $sentence = array_slice(preg_split('~(?<=[.!?])\s*(?=[A-ZА-ЯЁ])~', $str), 0, 1)[0];
    $sentence = strip_tags($sentence);
    return $sentence;
}


// post read time
function get_read_time()
{
    $text = get_the_content('');
    $words = str_word_count(strip_tags($text), 0, 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ');

    if (!empty($words)) {
        $time_in_minutes = ceil($words / 200);
        return $time_in_minutes;
    }
    return false;
}


/**
 * Render adaptive images with classes
 *
 * @param array $images [
 *     [
 *         'class' => 'db-1281',
 *         'image' => $acf_image
 *     ],
 * ]
 *
 * @param string $alt
 */
function render_adaptive_images($images = [], $alt = '')
{
    $valid_images = [];

    foreach ($images as $item) {

        if (
            empty($item['image']) ||
            empty($item['image']['url'])
        ) {
            continue;
        }

        $valid_images[] = [
            'class' => $item['class'] ?? '',
            'url'   => $item['image']['url'],
            'alt'   => $item['image']['alt'] ?? $alt,
        ];
    }

    if (empty($valid_images)) {
        return;
    }

    // Если осталась только одна картинка,
    // класс больше не нужен
    $single = count($valid_images) === 1;
    foreach ($valid_images as $item):
        $class = $single ? '' : $item['class'];
?>
        <img<?php if ($class): ?>
            class="<?= esc_attr($class); ?>"
            <?php endif; ?>
            src="<?= esc_url($item['url']); ?>"
            alt="<?= esc_attr($item['alt']); ?>">
    <?php
    endforeach;
}


// chipsa url
function get_chipsa_project_url()
{

    $host = wp_parse_url(home_url(), PHP_URL_HOST);

    $host = preg_replace('/^www\./i', '', $host);

    $project_name = explode('.', $host)[0];

    $language = function_exists('pll_current_language')
        ? pll_current_language('slug')
        : 'ru';

    $base_url = ('en' === $language)
        ? 'https://chipsa.ru/'
        : 'http://chipsa.ru/';

    return add_query_arg(
        array(
            'utm_source'   => $project_name,
            'utm_medium'   => 'works',
            'utm_campaign' => 'all',
        ),
        $base_url
    );
}

function get_home_page_url()
{

    $home_url = home_url();

    if (function_exists('pll_home_url')) {
        $home_url = pll_home_url();
    }

    return esc_url($home_url);
}



/*
для hero:
echo theme_image(
    'dist/img/hero.webp',
    [
        'alt'           => 'Hero',
        'loading'       => 'eager',
        'fetchpriority' => 'high',
    ]
);

для остальных
echo theme_image(
    'dist/img/about.webp',
    ['alt' => 'About company']
);
*/
function theme_image(
    string $path,
    array $attr = []
): string {
    $relative = ltrim($path, '/');

    $root = realpath(get_stylesheet_directory());
    $file = $root
        ? realpath($root . '/' . $relative)
        : false;

    // Разрешаем только файлы внутри активной темы.
    if (
        !$root ||
        !$file ||
        !str_starts_with($file, $root . DIRECTORY_SEPARATOR) ||
        !is_file($file)
    ) {
        return '';
    }

    // Не читаем размеры одного файла повторно за запрос.
    static $dimensions = [];

    if (!array_key_exists($file, $dimensions)) {
        $dimensions[$file] = wp_getimagesize($file);
    }

    $size = $dimensions[$file];

    $defaults = [
        'src'      => get_stylesheet_directory_uri()
            . '/' . implode(
                '/',
                array_map('rawurlencode', explode('/', $relative))
            ),
        'alt'      => '',
        'loading'  => 'lazy',
        'decoding' => 'async',
    ];

    if ($size) {
        $defaults['width']  = $size[0];
        $defaults['height'] = $size[1];
    }

    $attr = array_merge($defaults, $attr);

    $html = '<img';

    foreach ($attr as $name => $value) {
        if ($value === false || $value === null) {
            continue;
        }

        $html .= sprintf(
            ' %s="%s"',
            esc_attr($name),
            esc_attr((string) $value)
        );
    }

    return $html . '>';
}
