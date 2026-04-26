<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    // On s'assure que TOUTES les routes commençant par api/ sont autorisées
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // On autorise ton frontend React (port 3000)
    'allowed_origins' => ['http://localhost:3000', 'http://127.0.0.1:3000'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    /* | IMPORTANT : Passe à 'true' si tu utilises l'authentification (Sanctum/Sessions)
    | Sinon, garde 'false' mais assure-toi que l'origine est bien définie au-dessus.
    */
    'supports_credentials' => true,

];
