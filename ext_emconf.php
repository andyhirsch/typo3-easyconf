<?php

/*
 * This file is part of the composer package buepro/typo3-easyconf.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF[$_EXTKEY] = [
    'title'            => 'Easyconf',
    'description'      => 'Provides a module to easily configure main aspects from a website.',
    'category'         => 'module',
    'version'          => '1.3.2-dev',
    'state'            => 'stable',
    'clearCacheOnLoad' => 1,
    'author'           => 'Roman Büchler',
    'author_email'     => 'rb@buechler.pro',
    'constraints'      => [
        'depends'   => [
            'php'                   => '7.4.0-8.0.99',
            'typo3'                 => '11.5.0-11.5.99',
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'Buepro\\Easyconf\\' => 'Classes'
        ],
    ],
];
