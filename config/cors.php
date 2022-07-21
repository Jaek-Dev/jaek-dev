<?php

if(!\function_exists('get_host')) {
    function get_host() {
        $server_host = preg_replace( '/http(s)?:\/\//i', '', \env('APP_URL', '') );
        //Then match the HTTP_HOST
        $match_pattern = "/([a-zA-Z0-9-]+)\.([a-zA-Z0-9-]+)\.([a-zA-Z]+)/i";
        \preg_match( $match_pattern, $server_host, $matches );
        if( !empty( $matches ) ) {
            /**
             * A match has been found. It should look like below
             * 1.	subdomain.example.com
             * 2.	subdomain
             * 3.	example
             * 4.	com
             *
             * So, We'll only remove the first and the second, then join the remaining
             * to get the main domain
             */
            \array_shift( $matches );
            \array_shift( $matches );
            //The first and second has been removed. Now join the remaining
            return \implode( ".", $matches );
        } else return \str_replace( "www.", "", $server_host );
    }
}

$allowedOriginsPattern = (\env('APP_ENV') !== 'production') ?
    "/([a-zA-Z0-9-]+\.)?".\get_host()."(\.[a-zA-Z]+)(:[\d]+)?/i" :
    "/([a-zA-Z0-9-]+\.)?".\get_host()."\.([a-zA-Z]+)(:[\d]+)?/i";

$allowedOrigins = [
    \get_host(), 
    '*.'.\get_host()
];

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
