# Ombala Notifications Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dsilva01/ombala-sms.svg?style=flat-square)](https://packagist.org/packages/dsilva01/ombala)
[![Total Downloads](https://img.shields.io/packagist/dt/dsilva01/ombala-sms.svg?style=flat-square)](https://packagist.org/packages/dsilva01/ombala)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/dsilva01/ombala-sms/run-tests.yml?style=flat-square)](https://github.com/dsilva01/ombala-sms/actions/workflows/run-tests.yml)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package makes it easy to send notifications using [Ombala](https://www.useombala.ao/) with Laravel and 9.x and 10.x.

## Contents

- [Installation](#installation)
	- [Setting up the ombala](#setting-up-the-ombala-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
	- [ On-Demand Notifications](#on-demand-notifications)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:
``` bash
composer require dsilva01/ombala-sms
```

### Setting up the Ombala service

Add your Ombala token, default from name (or phone number) to your config/services.php:

```php
// config/services.php
...
'ombala' => [
    'endpoint' => env('OMBALA_ENDPOINT', 'https://api.useombala.ao/v1/messages'),
    'token' => env('OMBALA_TOKEN', 'YOUR OMBALA TOKEN HERE'),
    'from' => env('OMBALA_SENDER', 'YOUR OMBALA SENDER HERE')
],
...
```

## Usage

You can use the channel in your via() method inside the notification:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\Ombala\OmbalaMessage;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return ["ombala"];
    }

    public function toOmbala($notifiable)
    {
        return (new OmbalaMessage)->content("Your account was approved!");       
    }
}
```

In your notifiable model, make sure to include a routeNotificationForOmbala() method, which returns a phone number or an array of phone numbers.

```php
public function routeNotificationForOmbala()
{
    return $this->phone;
}
```
### On-Demand Notifications
Sometimes you may need to send a notification to someone who is not stored as a "user" of your application. Using the Notification::route method, you may specify ad-hoc notification routing information before sending the notification:

```php
Notification::route('ombala', '9123123321')                      
            ->notify(new InvoicePaid($invoice));
```
### Available Message methods

`from()`: Sets the from's name. *Make sure to register the from name at you Ombala dashboard.*

`content()`: Set a content of the notification message. This parameter should be no longer than 918 char(6 message parts),

`test()`: Send a test message to specific mobile number or not. This parameter should be boolean and default value is `true`.

## Testing

``` bash
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/dsilva01/ombala-sms/blob/master/.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Desiderio Silva](https://github.com/dsilva01)
- [Tint Naing Win](https://github.com/tintnaingwinn)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
