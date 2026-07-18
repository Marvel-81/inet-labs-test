<?php


return [
    'paths' => ['api/*'],
    'allowed_methods' => ['GET', 'POST'],
    'allowed_origins' => ['*'],
    'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
    'supports_credentials' => false,
];
