<?php

return [
    'name'        => 'MauticNameDayBundle',
    'description' => 'Names day segment filter for Mautic',
    'author'      => 'mtcextendee.com',
    'version'     => '1.0.0',
    'routes'      => [
    ],
    'services'    => [
        'events' => [
            'mautic.nameday.segment.filter.subscriber' => [
                'class'     => \MauticPlugin\MauticNameDayBundle\EventListener\SegmentFiltersSubscriber::class,
                'arguments' => [
                    'mautic.helper.integration'
                ],
            ],
        ],
        'others' => [
        ],
        'integrations' => [
            'mautic.integration.name_day_slovakia' => [
                'class'     => \MauticPlugin\MauticNameDayBundle\Integration\NameDaySlovakiaIntegration::class,
                'arguments' => [
                ],
            ],

            'mautic.integration.name_day_czech' => [
                'class'     => \MauticPlugin\MauticNameDayBundle\Integration\NameDayCzechIntegration::class,
                'arguments' => [
                ],
            ],
        ],
    ],
];
