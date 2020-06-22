<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'PHP Class Builder',
    'description' => 'Create and render new php class file.',
    'category' => 'be',
    'author' => 'Samuel Mihal',
    'author_email' => 'samuel.mihal@digitalwerk.agency',
    'author_company' => 'Digitalwerk',
    'state' => 'stable',
    'version' => '0.0.6',
    'constraints' => [
        'depends' => [
            'php' => '7.2.0-7.3.999',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Digitalwerk\\PHPClassBuilder\\' => 'Classes'
        ]
    ],
];
