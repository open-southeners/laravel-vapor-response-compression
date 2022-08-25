<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Response Compression
    |--------------------------------------------------------------------------
    |
    | Here you can configure the response size (in bytes) for the compression
    | threshold, as compressing small responses will result in processing
    | time and result response size penalty for both client and server.
    |
    */

    'enable' => env('RESPONSE_COMPRESSION_ENABLE', true),

    // @see https://docs.aws.amazon.com/apigateway/latest/developerguide/limits.html#http-api-quotas
    'threshold' => 10000,

    'level' => [

        // @see https://paulcalvano.com/2018-07-25-brotli-compression-how-much-will-it-reduce-your-content/
        'br' => 10, // brotli

        // @see https://www.php.net/manual/en/function.gzencode.php
        'gzip' => 9,

        // @see https://www.php.net/manual/en/function.gzdeflate.php
        'deflate' => 9,

    ],

];
