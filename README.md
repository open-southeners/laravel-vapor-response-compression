# Laravel Vapor Response Compression

Add server-side response compression with different algorithm support (Gzip, brotli, deflate...)

## Status

[![latest tag](https://img.shields.io/github/v/tag/open-southeners/laravel-vapor-response-compression?label=latest&sort=semver)](https://github.com/open-southeners/laravel-vapor-response-compression/releases/latest) [![packagist version](https://img.shields.io/packagist/v/open-southeners/laravel-vapor-response-compression)](https://packagist.org/packages/open-southeners/laravel-vapor-response-compression) [![required php version](https://img.shields.io/packagist/php-v/open-southeners/laravel-vapor-response-compression)](https://www.php.net/supported-versions.php) [![run-tests](https://github.com/open-southeners/laravel-vapor-response-compression/actions/workflows/tests.yml/badge.svg?branch=main)](https://github.com/open-southeners/laravel-vapor-response-compression/actions/workflows/tests.yml) [![phpstan](https://github.com/open-southeners/laravel-vapor-response-compression/actions/workflows/phpstan.yml/badge.svg)](https://github.com/open-southeners/laravel-vapor-response-compression/actions/workflows/phpstan.yml) [![Laravel Pint](https://img.shields.io/badge/code%20style-pint-orange?logo=laravel)](https://github.com/open-southeners/laravel-vapor-response-compression/actions/workflows/pint.yml) [![codecov](https://codecov.io/gh/open-southeners/laravel-vapor-response-compression/branch/main/graph/badge.svg?token=Q31AYXXGOA)](https://codecov.io/gh/open-southeners/laravel-vapor-response-compression) [![Edit on VSCode online](https://img.shields.io/badge/vscode-edit%20online-blue?logo=visualstudiocode)](https://vscode.dev/github/open-southeners/laravel-vapor-response-compression)

## Why use this package?

The reason why is because AWS **hard limit its API Gateway** service to 10MB (at the date of writing this), and by hard we mean that there's no way you can increase this limitation.

**Note: Thought CloudFlare is a good solution for the end user, it doesn't solve this issue as CloudFlare does this between the server and the client, so the response already passed through AWS (API Gateway).**

Read more here: https://docs.aws.amazon.com/apigateway/latest/developerguide/limits.html#http-api-quotas

Or on our blog article: https://opensoutheners.com/how-to-prevent-large-responses-to-trigger-502-errors

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
