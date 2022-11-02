### Requirements

- PHP 5.3 or later

### Installation

```
$ composer require codd-tech/bap-sdk-php
```

### Usage

```php
$bap = new \CoddTech\Bap\BAP('<api key>');
$bap->handleTelegramUpdates($update->toArray());
```
