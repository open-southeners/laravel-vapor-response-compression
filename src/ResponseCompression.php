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

                $responseHeaders = [
                    'Content-Encoding' => $algo,
                ];
                
                if (getenv('VAPOR_SSM_PATH')) {
                    $responseHeaders['X-Vapor-Base64-Encode'] = 'True';
                }
                
                $response->headers->add($responseHeaders);
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
            && strlen($response->getContent() ?: '') >= config('response-compression.threshold', 10000);
    }

    /**
     * Determine which algorithm should be used to compress the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array{0: string, 1: callable-string}|null
     */
    protected function shouldCompressUsing($request): ?array
    {
        $supportedList = CompressionEncoding::listSupported();
        
        $fromSupportedList = array_intersect($request->getEncodings(), array_keys($supportedList));

        if ($fromSupportedList[0] ?? false) {
            return [$fromSupportedList[0], $supportedList[$fromSupportedList[0]]];
        }
        
        return null;
    }
}
