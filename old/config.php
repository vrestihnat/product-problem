<?php

return [
    //..... 
    'cacheDriver' => 'FSCacheDriverFactory',
    'db_SQLConnector' => [
        'connection' => 'mysql:host=localhost;dbname=myProducts',
        'db_user' => '...',
        'db_passwd' => '...',
    ],
    'db_ESConnector' => [
        'enable' => true,
        'hosts' => ['localhost:9200'],
    ],
    //.....  
];

