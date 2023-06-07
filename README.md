# Bot Advertising Platform SDK

This repository holds SDK related to
[Bot Advertising Platform](https://publisher.socialjet.pro/).

## Requirements

- PHP 5.3 or later
- ext-sockets

## Installation

Install the latest version with

```bash
composer require codd-tech/bap-sdk-php
```

### Installing ext-sockets

The [socket extension](https://www.php.net/manual/en/book.sockets.php) implements a low-level interface to the socket communication.

The BAP SDK uses the UDP protocol for data transfer to ensure minimal SDK overhead for the user.

To install socket extension add the following line to your `php.ini`:

```ini
extension=php_sockets.dll
```

Or add `RUN docker-php-ext-install sockets` to your project's Dockerfile if you are using [official php image](https://hub.docker.com/_/php). 



## Usage

SDK accepts single update from the Telegram bot as an associative array.

### Basic usage

```php
$bap = new \CoddTech\Bap\BAP('<api key>');
$bap->handleTelegramUpdates($update);
```

### Usage with PHP Telegram Bot package

If you are using [PHP Telegram Bot]() package you can call SDK inside custom update filter, eg:

```php
$telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

$telegram->setUpdateFilter(function (Update $update, Telegram $telegram, &$reason = 'Update denied by update_filter') {
    $bap = new \CoddTech\Bap\BAP('<api key>');
    $bap->handleTelegramUpdates($update->getRawData());

    return true;
});
```

### API Key

**API key is not your Telegram bot token.**

API key must be obtained from [socialjet.pro](https://publisher.socialjet.pro/)

## About

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/codd-tech/bap-sdk-php)

### License

Bot Advertising Platform SDK is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
