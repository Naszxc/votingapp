<?php    
    return [
        'paths' => ['api/*', 'sanctum/csrf-cookie', '/saveData'],
        'allowed_methods' => ['*'],
        'allowed_origins' => ['http://localhost'],
        'allowed_origins_patterns' => [],
        'allowed_headers' => ['Content-Type', 'X-Requested-With', 'Authorization', 'X-CSRF-TOKEN'],
        'exposed_headers' => [],
        'max_age' => 0,
        'supports_credentials' => true,
    ];
?>