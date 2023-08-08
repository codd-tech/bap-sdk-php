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

If your advertisement mode is set to **manual** you can mark ad placement in your code by calling:
```php
$bap->advertisement($update);
```

**Interrupting control flow**

At times, BAP may introduce telegram updates within its advertisement flow. To maintain the logical consistency of your bot, it is necessary to ignore such updates.  

The `BAP::handleTelegramUpdates` method returns a boolean value indicating whether you should proceed with handling the request or skip it as an internal BAP request.

When the method returns `false`, it signifies that the current request should not be processed by your bot.

### Usage with PHP Telegram Bot package

If you are using [PHP Telegram Bot]() package you can call SDK inside custom update filter, eg:

```php
$telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

$bap = new \CoddTech\Bap\BAP('<api key>');
$telegram->setUpdateFilter(function (Update $update, Telegram $telegram, &$reason = 'Update denied by update_filter') use ($bap) {
    return $bap->handleTelegramUpdates($update->getRawData());
});
```

For manual advertisement mode(Should be turned on in settings) call following in the desired ad placements.

```php
$bap->advertisement($update);
```

### API Key

**API key is not your Telegram bot token.**

API key must be obtained from [socialjet.pro](https://publisher.socialjet.pro/)

## About

### Submitting bugs and feature requests

Bugs and feature request are tracked on [GitHub](https://github.com/codd-tech/bap-sdk-php)

### License

Bot Advertising Platform SDK is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
