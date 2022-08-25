# Laravel Vapor Response Compression

Add server-side response compression with different algorithm support (Gzip, brotli, deflate...)

## Status

[![latest tag](https://img.shields.io/github/v/tag/open-southeners/laravel-vapor-response-compression?label=latest&sort=semver)](https://github.com/open-southeners/laravel-vapor-response-compression/releases/latest) [![packagist version](https://img.shields.io/packagist/v/open-southeners/laravel-vapor-response-compression)](https://packagist.org/packages/open-southeners/laravel-vapor-response-compression) [![run-tests](https://github.com/open-southeners/laravel-vapor-response-compression/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/open-southeners/laravel-vapor-response-compression/actions/workflows/tests.yml) [![phpstan](https://github.com/open-southeners/laravel-vapor-response-compression/actions/workflows/phpstan.yml/badge.svg)](https://github.com/open-southeners/laravel-vapor-response-compression/actions/workflows/phpstan.yml) [![Laravel Pint](https://img.shields.io/badge/code%20style-Laravel%20Pint-orange?logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAABJklEQVQokYWSsUrDUBSGv3MJFheX4NTF1d2HkLxBkQSdxUHo5CSKdBNE8AGqQ3FwE/oGji6+QBcFqxYcDG1zcx1OEm8k0X873PPx/+fnCp7cDWtYzhC2gQ3AAROEMSF9iZiXu1JBQyIcdwgdmrVAiCXmtgLdkAi4RwIwQTOWZ+AygJ4kjKSI94rQYfMQts6bwccjeBqoc0o3KG7SeHkK2Ycu2lkdzKp5hVUOgqII1ecDbnqpNz8f1zh58QqBfYO2p1p+NcfUgL5Cg1ZexJnTJqmDGGBSTfbXqy9Xm6YGYfzj+AdYs+fKENKnvMC2R/UcLYYLIxFzhPjfqKoc2JMdZgag+EY97HKBy9sgC+xKwjVoORo7YURKV1x2Crx7wBtwgmG9hAC+ARx+XdbTi0UAAAAAAElFTkSuQmCC)](https://github.com/open-southeners/laravel-vapor-response-compression/actions/workflows/pint.yml) [![Codacy Badge](https://app.codacy.com/project/badge/Grade/b9e093b1665848a295d86f7e6b54fe36)](https://www.codacy.com/gh/open-southeners/laravel-vapor-response-compression/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=open-southeners/laravel-vapor-response-compression&amp;utm_campaign=Badge_Grade) [![Codacy Badge](https://app.codacy.com/project/badge/Coverage/b9e093b1665848a295d86f7e6b54fe36)](https://www.codacy.com/gh/open-southeners/laravel-vapor-response-compression/dashboard?utm_source=github.com&utm_medium=referral&utm_content=open-southeners/laravel-vapor-response-compression&utm_campaign=Badge_Coverage) [![Scc Count Badge](https://sloc.xyz/github/open-southeners/laravel-vapor-response-compression?category=code)](https://github.com/open-southeners/laravel-vapor-response-compression) [![Scc Count Badge](https://sloc.xyz/github/open-southeners/laravel-vapor-response-compression?category=comments)](https://github.com/open-southeners/laravel-vapor-response-compression) [![Take a peek on VSCode online](https://img.shields.io/badge/vscode-Take%20a%20peek-blue?logo=data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAAOCAYAAAAfSC3RAAACJklEQVQoFYVSS2hTURCdue8l7cv3NT8bYrMqCtYitRZEKKIrwW6kGy0obtzpoqCIC/GBoEUptKDQLgRBKIo7FUW6EHFTN1XxW900IAZFbEiwecn9jPNSGkWwDgz3ztxzzswwF+E/Nujdj8Ri0dPRTGHUyeSnmwT3arF4BTfiDU7MF22CC4LoeDxXENFcEYjgtQG6+U/i0JUn3dRUM4g0wmgrni1AdFOR6wQUXLV3XHu5hSg8LBU8fD++rQxAOODN56Uv5/i+t9URGaUIpTLgBDEBRbBv+u0zvu3h8Kk2NCFWSnVEaxIQhwIQ669y1dls70DWdqJjBCACqq2MniHC7Qi4j/vvJzsiofGzG4QVsD4LglNuyn1MHZHzynCtQI3NXip8uN1b2trJiSlCkYFIhgVZ1K9+stA6unT54PMAOHynGhxtE33vwGp8K2m5Ulaq6QPPAcpJgUz2VPxkTwd4gQrngvwfLr7XwscUwaRs1F3540tdKvVVcksKxC5lzFy+89VYi8gtMY6d39htxpzRRscR4Y0gdQIFaq3hBoDp5yELYOBW5uKLnX6jEbND4XarNhl9xADuN026W7k+WgpeUpcWD5PGqyx8oDUwmZO1atWPd6W57bXVt7YJnofsPMFvc7yFzRaEpwjwEBglXNeFRCq3DjBr9PXwrzN2bjErQzQLWo8wMZRI5yTvdxk3+nJtDW8hEdbW2USya3fCTT8wWj9aLqc//gJwC/Y8vXqalgAAAABJRU5ErkJggg==)](https://vscode.dev/github/open-southeners/laravel-vapor-response-compression)

## Why use this package?

The reason why is because AWS **hard limit its API Gateway** service to 10MB (at the date of writing this), and by hard we mean that there's no way you can increase this limitation.

**Note: Thought CloudFlare is a good solution for the end user, it doesn't solve this issue as CloudFlare does this between the server and the client, so the response already passed through AWS (API Gateway).**

Read more here: https://docs.aws.amazon.com/apigateway/latest/developerguide/limits.html#http-api-quotas

## Getting started

```bash
composer require open-southeners/laravel-vapor-response-compression
```

Then publish the configuration file defaults into your application's config folder:

```bash
php artisan vendor:publish --tag=response-compression
```

Then add the following to you `app/Http/Kernel.php` as a global middleware:

**Note: Remember this is different in older versions of Laravel, Laravel 9 should look like the following.**

```php
/**
 * The application's global HTTP middleware stack.
 *
 * These middleware are run during every request to your application.
 *
 * @var array<string, array<int, class-string|string>>
 */
protected $middleware = [
    // ...
    \OpenSoutheners\LaravelVaporResponseCompression\ResponseCompression::class,
];
```

### Configuration

If you already have this `config/response-compression.php` file, you can skip this step, otherwise please use the following artisan command first:

```bash
php artisan vendor:publish --tag=response-compression
```

**Note: As for smaller responses this threshold will prevent to compress the response if it doesn't reach an specific number of bytes. We encourage you to configure this and not leave it as ±0 bytes otherwise response will be always compressed.**

This configuration is **defaulted to 10000 bytes**, you may customise this as your application demands.

### Setting up Brotli extension in Vapor

First of all, **this will require you to use Docker containers on your Vapor environments** if you're not familiar with them, you can still use this extension as **it uses the first client requested algorithm available at server side**.

👉 [Read more about using containers in Vapor here](https://docs.vapor.build/1.0/projects/environments.html#docker-runtimes)

Anyway, in case you want to proceed, add this to your environment Dockerfile(s), **please use comments as references only**:

```Dockerfile
# FROM laravelphp/vapor:php81

RUN apk add --no-cache brotli

# COPY . /var/task
```

And ensure your project depends on [vdechenaux/brotli](https://github.com/vdechenaux/brotli-php).

### Alternative Brotli setup

Another alternative is to use: https://github.com/kjdev/php-ext-brotli

_TODO: Setup instructions for Vapor/Dockerfile_

## Credits

- To [@jryd_13](https://twitter.com/@jryd_13) for writing [the article](https://bannister.me/blog/gzip-compression-on-laravel-vapor/) that [gave me this idea]()
