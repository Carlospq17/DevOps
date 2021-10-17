<?php

return [
    'error' => [
        'entity_not_found' => ':entityName with id :entityId not found, no action was perfomed.',
        'entry_duplicate' => ':entityName with :key :value already exist, action refused.'
    ],

    'http_method' => [
        'post' => ':entityName Created',
        'getId' => ':entityName Found',
        'get' => ':entityName List Found',
        'delete' => ':entityName Deleted',
        'put' => ':entityName Updated'
    ],

    'validate' => [
        'invalid_post' => 'Invalid :entityName Post Request Structure',
        'invalid_put' => 'Invalid :entityName Update Request Structure'
    ]
];
