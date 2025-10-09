<?php
return [
    'paths' => ['api/*'],  // Allow CORS only for your API routes
    'allowed_methods' => ['*'], // Allow GET, POST, PUT, DELETE, etc.
    'allowed_origins' => ['*'], // Replace '*' with your frontend URL in production
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
