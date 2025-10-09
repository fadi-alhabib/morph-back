<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin requests.
    |
    */

    'paths' => ['api/*'],  // Apply CORS to all your API routes

    'allowed_methods' => ['*'], // GET, POST, PUT, DELETE, etc.
    
    'allowed_origins' => ['https://morphicarts.sa'], // Frontend URL only
    // 'allowed_origins' => ['*'], // Only use '*' for testing; not for production

    'allowed_origins_patterns' => [],
    
    'allowed_headers' => ['*'], // Allow all headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // set true if you use cookies or auth headers
];
