<?php

namespace OpenSoutheners\LaravelVaporResponseCompression;

use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResponseCompression
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return tap($next($request), function ($response) use ($request) {
            $compressionAlgorithm = $this->shouldCompressUsing($request);

            if ($this->shouldCompressResponse($response) && $compressionAlgorithm !== null) {
                [$algo, $function] = $compressionAlgorithm;

                $response->setContent(
                    call_user_func(
                        $function,
                        $response->getContent(),
                        config("response-compression.level.{$algo}", 9)
                    )
                );

                $response->headers->add([
                    'Content-Encoding' => $algo,
                    'X-Vapor-Base64-Encode' => 'True',
                ]);
            }
        });
    }

    /**
     * Determine if response should be compressed.
     *
     * @param  \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response  $response
     */
    protected function shouldCompressResponse($response): bool
    {
        return ! $response instanceof BinaryFileResponse
            && ! $response instanceof StreamedResponse
            && ! $response->headers->has('Content-Encoding')
            && config('response-compression.enable', true)
            && strlen($response->getContent()) >= config('response-compression.threshold', 10000);
    }

    /**
     * Determine which algorithm should be used to compress the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string>|null
     */
    protected function shouldCompressUsing($request)
    {
        $requestEncodings = $request->getEncodings();

        if (in_array(CompressionEncoding::ZSTANDARD, $requestEncodings) && function_exists('zstd_compress')) {
            return [CompressionEncoding::ZSTANDARD, 'zstd_compress'];
        }
        
        if (in_array(CompressionEncoding::BROTLI, $requestEncodings) && function_exists('brotli_compress')) {
            return [CompressionEncoding::BROTLI, 'brotli_compress'];
        }

        if (in_array(CompressionEncoding::GZIP, $requestEncodings) && function_exists('gzencode')) {
            return [CompressionEncoding::GZIP, 'gzencode'];
        }

        if (in_array(CompressionEncoding::DEFLATE, $requestEncodings) && function_exists('gzdeflate')) {
            return [CompressionEncoding::DEFLATE, 'gzdeflate'];
        }

        return null;
    }
}
