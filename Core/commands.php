<?php

return [
    [
        'command' => 'migration:create',
        'description' => 'Create a migration file',
        'arguments' => [
            [
                'name' => 'name',
                'description' => 'Migration file name',
                'required' => true
            ]
        ]
    ],
    [
        'command' => 'migration:run',
        'description' => 'Run all migrations',
        'arguments' => []
    ]
];