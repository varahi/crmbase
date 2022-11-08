<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'T3Dev',
    'description' => 'Configurations supplémentaires pour la plateforme TYPO3',
    'category' => 'plugin',
    'author' => 'Dmitry Vasilev',
    'author_email' => 'info@t3dev.ru',
    'state' => 'alpha',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '10.4.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
);
