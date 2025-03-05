<?php

namespace OpenSoutheners\LaravelResponseCompression;

use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseCompression
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next)
    {
        return tap($next($request), function ($response) use ($request) {
            $compressionAlgorithm = $this->shouldCompressUsing($request);

            if ($this->shouldCompressResponse($response) && $compressionAlgorithm !== null) {
                [$algo, $function] = $compressionAlgorithm;

                /** @var string $compressedContent */
                $compressedContent = call_user_func(
                    $function,
                    $response->getContent(),
                    config("response-compression.level.{$algo}", 9)
                );
                
                $response->setContent($compressedContent);

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
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     */
    protected function shouldCompressResponse($response): bool
    {
        if (
            $response instanceof BinaryFileResponse
                || $response instanceof StreamedResponse
                || !config('response-compression.enable', true)
        ) {
            return false;
        }
        
        if (
            ! $response->headers->has('Content-Encoding')
                && strlen($response->getContent() ?: '') >= config('response-compression.threshold', 10000)
        ) {
            return true;
        }
        
        return false;
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
