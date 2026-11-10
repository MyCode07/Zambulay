<?php

add_filter('wpcf7_autop_or_not', '__return_false');
// Keep field wrappers: CF7 needs them for validation and accessible errors.

// Apply the same limit to rendered inputs and CF7's validation schema without editing form records.
add_filter('wpcf7_form_tag', function ($tag) {
    // Existing form records use [text phone]; treat those as telephone fields too.
    if (($tag['name'] ?? '') === 'phone' && ($tag['basetype'] ?? '') === 'text') {
        $tag['basetype'] = 'tel';
        $tag['type'] = str_ends_with($tag['type'], '*') ? 'tel*' : 'tel';
    }
    if (($tag['basetype'] ?? '') === 'text' && in_array($tag['name'] ?? '', ['cname', 'location'], true)) {
        $tag['options'] = array_values(array_filter($tag['options'], static fn($option) => !str_starts_with($option, 'maxlength:')));
        $tag['options'][] = 'maxlength:40';
    }
    return $tag;
});

function frame_cf7_is_alphabetic($value)
{
    return preg_match("/^[\\p{L}\\p{M}\\p{Zs}'’ʼ‐‑-]+$/uD", $value)
        && preg_match('/\\p{L}/u', $value);
}

function frame_cf7_is_user_text($tag)
{
    return in_array($tag->basetype, ['text', 'textarea', 'email', 'tel', 'url'], true)
        && !str_contains($tag->name, 'honeypot') && $tag->name !== 'wpcf7_hp_field';
}

add_filter('wpcf7_posted_data', function ($data) {
    $form = WPCF7_ContactForm::get_current();
    if (!$form) return $data;
    foreach ($form->scan_form_tags() as $tag) {
        if (frame_cf7_is_user_text($tag) && isset($data[$tag->name]) && is_string($data[$tag->name])) {
            $data[$tag->name] = preg_replace('/^\s+|\s+$/u', '', $data[$tag->name]);
        }
    }
    return $data;
});

add_filter('wpcf7_validate', function ($result, $tags) {
    $submission = WPCF7_Submission::get_instance();
    if (!$submission) return $result;
    foreach ($tags as $tag) {
        if (!frame_cf7_is_user_text($tag)) continue;
        $value = $submission->get_posted_data($tag->name);
        if (!is_string($value) && $value !== null) {
            $result->invalidate($tag, wpcf7_get_message('invalid_required'));
            continue;
        }
        $value = (string) $value;
        if ($tag->is_required() && $value === '') {
            $result->invalidate($tag, wpcf7_get_message('invalid_required'));
        } elseif ($tag->basetype !== 'email' && $value !== '' && mb_strlen($value) < 2) {
            $result->invalidate($tag, wpcf7_get_message('invalid_too_short'));
        } elseif ($value !== '' && in_array($tag->name, ['cname', 'location'], true)) {
            if (mb_strlen($value) > 40) $result->invalidate($tag, wpcf7_get_message('invalid_too_long'));
            elseif (!frame_cf7_is_alphabetic($value)) {
                $result->invalidate($tag, str_starts_with(get_bloginfo('language'), 'ru')
                    ? 'Допустимы буквы, пробелы, дефисы и апострофы'
                    : 'Use letters, spaces, hyphens and apostrophes');
            }
        } elseif ($tag->basetype === 'tel' && $value !== '' && !preg_match('/^\+?[0-9]+$/D', $value)) {
            $result->invalidate($tag, wpcf7_get_message('invalid_tel'));
        }
    }
    return $result;
}, 20, 2);

// Preserve checkbox rules, but allow the optional budget radio group to be empty.
add_action('wpcf7_init', function () {
    remove_action('wpcf7_swv_create_schema', 'wpcf7_swv_add_checkbox_rules', 10);
    add_action('wpcf7_swv_create_schema', 'frame_cf7_checkbox_rules', 10, 2);
});

function frame_cf7_checkbox_rules($schema, $form)
{
    $tags = $form->scan_form_tags();
    $budget = null;
    $custom = null;
    foreach ($tags as $tag) {
        if ($tag->name === 'budget' && $tag->type === 'radio') $budget = $tag;
        if ($tag->name === 'budget_custom' && $tag->basetype === 'text') $custom = $tag;
    }
    if (!$budget || !$custom) {
        wpcf7_swv_add_checkbox_rules($schema, $form);
        return;
    }
    foreach ($tags as $tag) {
        if (!in_array($tag->basetype, ['checkbox', 'radio'], true)) continue;
        if ($tag->name !== 'budget' && ($tag->is_required() || $tag->type === 'radio')) {
            $schema->add_rule(wpcf7_swv_create_rule('required', [
                'field' => $tag->name,
                'error' => wpcf7_get_message('invalid_required'),
            ]));
        }
        if ($tag->type === 'radio' || $tag->has_option('exclusive')) {
            $schema->add_rule(wpcf7_swv_create_rule('maxitems', [
                'field' => $tag->name,
                'threshold' => 1,
                'error' => $form->filter_message(__('Too many items are selected.', 'contact-form-7')),
            ]));
        }
    }
}


add_filter('wpcf7_mail_components', 'custom_cf7_multiple_recipients', 10, 3);
function custom_cf7_multiple_recipients($components, $contact_form, $submission)
{
    // Проверяем ID формы (если нужно только для определенной, например, ID 9)
    if (9 == $contact_form->id()) {
        $recipients = array(
            'den@adsbase.com',
        );

        // Перезаписываем получателя в готовых компонентах письма
        $components['recipient'] = implode(', ', $recipients);
    }

    return $components;
}
