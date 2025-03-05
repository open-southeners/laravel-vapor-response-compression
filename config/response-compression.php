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

    // Threshold size in bytes from where the compression will be applied to responses
    // @see https://docs.aws.amazon.com/apigateway/latest/developerguide/limits.html#http-api-quotas
    'threshold' => 10000,

    'level' => [

        // @see https://paulcalvano.com/2024-03-19-choosing-between-gzip-brotli-and-zstandard-compression/
        'zstd' => 11, // zstandard
        
        // @see https://paulcalvano.com/2018-07-25-brotli-compression-how-much-will-it-reduce-your-content/
        'br' => 9, // brotli

        // @see https://www.php.net/manual/en/function.gzencode.php
        'gzip' => 9,

        // @see https://www.php.net/manual/en/function.gzdeflate.php
        'deflate' => 9,
        
        // @see Maximum level is 12 at the moment of this written
        'lz4' => 4,

    ],

];
