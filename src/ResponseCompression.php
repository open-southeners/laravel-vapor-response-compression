<?php

namespace OpenSoutheners\LaravelVaporResponseCompression;

use Closure;

class ResponseCompression
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return tap($next($request), function ($response) use ($request) {
            $compressionAlgorithm = $this->shouldCompressUsing($request);

            if ($this->shouldCompressResponse($response, $request) && $compressionAlgorithm !== null) {
                [$algo, $function] = $compressionAlgorithm;

                $response->setContent(
                    call_user_func(
                        $function,
                        $response->getContent(),
                        config("vapor.response_compression.level.${algo}", 9)
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
     * @param  \Illuminate\Http\Response  $response
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldCompressResponse($response, $request): bool
    {
        return strlen($response->getContent()) >= config('vapor.response_compression.threshold', 10000);
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
