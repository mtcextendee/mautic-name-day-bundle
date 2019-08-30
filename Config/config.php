<?php

return [
    'name'        => 'MauticNameDayBundle',
    'description' => 'Slovakia name day segment filter for Mautic',
    'author'      => 'mtcextendee.com',
    'version'     => '1.0',
    'routes'      => [
    ],
    'services'    => [
        'events' => [
            'mautic.nameday.segment.filter.subscriber' => [
                'class'     => \MauticPlugin\MauticNameDayBundle\EventListener\FiltersSubscriber::class,
                'arguments' => [
                ],
            ],
        ],
        'others' => [
        ],
        'integrations' => [
            'mautic.integration.nameday' => [
                'class'     => \MauticPlugin\MauticNameDayBundle\Integration\NameDayIntegration::class,
                'arguments' => [
                ],
            ],
        ],
    ],
];
