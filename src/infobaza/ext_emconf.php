<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'infobaza',
    'description' => 'Information Database',
    'category' => 'plugin',
    'author' => 'Dmitry Vasilev',
    'author_email' => 'info@t3dev.ru',
    'state' => 'alpha',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
