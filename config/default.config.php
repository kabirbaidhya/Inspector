<?php

return [
    'generators' => [
        'form' => 'Analyzer\Generator\FormGenerator'
    ],
    'paths' => [
        'form' => 'forms/'
    ],
    'form' => [
        'use_bootstrap' => true
    ],
    'loc_threshold' => [
        'class' => 500,
        'method' => 80,
        'function' => 80
    ],
    'complexity_threshold' => [
        'class' => 20,
        'method' => 5,
        'function' => 5
    ]
];
