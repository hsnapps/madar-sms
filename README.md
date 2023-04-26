# MadarSMS notifications channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/:package_name.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/:package_name)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/:package_name/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/:package_name)
[![StyleCI](https://styleci.io/repos/:style_ci_id/shield)](https://styleci.io/repos/:style_ci_id)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/:package_name.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/:package_name)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/:package_name/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/:package_name/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/:package_name.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/:package_name)

This package makes it easy to send notifications using [MadarSMS](https://mobile.net.sa/) with Laravel.





## Contents

- [MadarSMS notifications channel for Laravel](#madarsms-notifications-channel-for-laravel)
  - [Contents](#contents)
  - [Installation](#installation)
    - [Setting up the Madar SMS service](#setting-up-the-madar-sms-service)
  - [Usage](#usage)
    - [Available Message methods](#available-message-methods)
  - [Changelog](#changelog)
  - [Testing](#testing)
  - [Security](#security)
  - [Contributing](#contributing)
  - [Credits](#credits)
  - [License](#license)


## Installation

This package can be installed via composer:

```composer require laravel-notification-channels/madar-sms```

### Setting up the Madar SMS service

1. Create an account in Madar SMS [here](https://mobile.net.sa)
2. Create configuration file `config/madar.php`, You can also publish the config file with the command:
```bash
php artisan vendor:publish --provider="NotificationChannels\Madar\MadarServiceProvider"
```

## Usage

You can use this channel by adding `MadarChannel::class` to the array in the `via()` method of your notification class. You need to add the `toMadarSms()` method which should return a `new MadarMessage()` object.

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Madar\MadarChannel;
use NotificationChannels\Madar\MadarMessage;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [MadarChannel::class];
    }

    public function toMadarSms() {
        return (new MadarMessage('Hallo!'))
        ->sender('Max');
    }
}
```


### Available Message methods

- `getPayloadValue($key)`: Returns payload value for a given key.
- `content(string $message)`: Sets SMS message text.
- `numbers(string $number)`: Set recipients number(s). 
- `sender(string $from)`: Set senders name.
- `delay(string $timestamp)`: Delays message to given timestamp.
- `repeat($repeat = '0')`: Allow the repeating of sms sending with same data.
- `by()`: The type of the API.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Hassan Ba Abdullah](https://github.com/hsnapps)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
