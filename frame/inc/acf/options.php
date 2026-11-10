<?php

if (function_exists('acf_add_options_page')) {
    add_action('acf/init', function () {

        acf_add_options_page([
            'page_title' => 'Глобальные поля',
            'menu_title' => 'Глобальные поля',
            'menu_slug'  => 'global-settings',
            'post_id'    => 'global_settings',
            'redirect'   => false,
        ]);

        acf_add_options_page([
            'page_title' => 'Переводы полей',
            'menu_title' => 'Переводы полей',
            'menu_slug'  => 'localized-settings',
            'post_id'    => 'localized_settings',
            'redirect'   => false,
        ]);
    });

    add_filter('bea.aofp.excluded_post_ids', function ($ids) {
        $ids[] = 'global_settings';

        return $ids;
    });
}

/**
 * Получить общее поле сайта.
 *
 * Одинаковое значение для всех языков.
 */
function get_global_field(
    string $name,
    bool $format = true
): mixed {
    return get_field(
        $name,
        'global_settings',
        $format
    );
}

/**
 * Получить переводимое поле.
 *
 * Язык автоматически определяется
 * интеграцией ACF + Polylang.
 */
function get_localized_field(
    string $name,
    bool $format = true
): mixed {
    return get_field(
        $name,
        'localized_settings',
        $format
    );
}
