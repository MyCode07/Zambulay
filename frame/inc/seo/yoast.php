<?php

if (!defined('ABSPATH')) {
    exit;
}

// Empty values preserve Yoast's data; name, logo and sameAs stay in its UI.
add_filter('wpseo_schema_organization', 'frame_yoast_organization_data');
function frame_yoast_organization_data($data)
{
    $organization = get_localized_field('organization');

    if (!$organization) return $data;


    $details = [
        'description' => $organization['description'] ?? '',
        'email' => $organization['email'] ?? '',
        'telephone' => $organization['telephone'] ?? '',
        'legalName' => $organization['legalname'] ?? '',
        'foundingDate' => $organization['foundingdate'] ?? '',
        'numberOfEmployees' => $organization['numberofemployees'] ?? 1,
    ];

    foreach ($details as $property => $value) {
        if ($value === '' || $value === null) {
            continue;
        }

        if ($property === 'numberOfEmployees') {
            $data[$property] = [
                '@type' => 'QuantitativeValue',
                'value' => (int) $value,
            ];
        } else {
            $data[$property] = $value;
        }
    }

    return $data;
}