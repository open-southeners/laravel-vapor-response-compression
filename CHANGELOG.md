# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.1] - 2023-02-02

### Fixed

- PHP 8.2 interpolation deprecations

## [2.0.0] - 2022-08-25

### Added

- Enable option following its environment variable `RESPONSE_COMPRESSION_ENABLE` (default: `true`)

### Changed

- Its dedicated config file (`config/response-compression.php`). Publishable by running the command: `php artisan vendor:publish --tag=response-compression`

## [1.0.0] - 2022-07-22

### Added

- Initial release! 
