<?php

return [
    'loc_threshold' => [
        'class' => 500,
        'method' => 80,
        'function' => 80
    ],
    'complexity_threshold' => [
        'class' => 20,
        'method' => 5,
        'function' => 5
    ],
    'messages' => require __DIR__ . '/../resources/messages/en_US/messages.php'
];
