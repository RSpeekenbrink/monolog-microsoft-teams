# Monolog Microsoft Teams
![Package Version](https://img.shields.io/badge/Version-1.0.0-brightgreen.svg)
![Packagist Version](https://img.shields.io/packagist/v/rspeekenbrink/monolog-microsoft-teams.svg)

A [Monolog](https://github.com/Seldaek/monolog) handler to send Microsoft Teams messages via the Incoming Webhook.

# Features
Send text messages to the incoming webhook of microsoft teams with different theme colors based on the log level. All this whilst using the well known monolog library as backbone!

# Install
```
composer require rspeekenbrink/monolog-microsoft-teams
```

# Usage
```php
<?php

use Monolog\Logger;
use Rspeekenbrink\MonologMicrosoftTeams\MicrosoftTeamsHandler;

// create a log channel
$log = new Logger('microsoft-teams-logger');
$log->pushHandler(new MicrosoftTeamsHandler(
    'YOUR_WEBHOOK_URL',
    'Fancy Title',
    Logger::WARNING
));

// add records to the log
$log->warning('Foo');
$log->error('Bar');
```

or

```php
<?php

use Rspeekenbrink\MonologMicrosoftTeams\MicrosoftTeamsLogger;

// create a log channel
$log = new MicrosoftTeamsLogger(
    'YOUR_WEBHOOK_URL',
    'Fancy Title',
    Logger::WARNING
);

// add records to the log
$log->warning('Foo');
$log->error('Bar');
```

# Usage with Laravel/Lumen framework
From Laravel/Lumen 5.6+ you can easily use custom drivers for logging. First create a [Custom Channel](https://laravel.com/docs/master/logging#creating-custom-channels).

in `config/logging.php` add:

```php
'teams' => [
    'driver' => 'custom',
    'via' => \Rspeekenbrink\MonologMicrosoftTeams\MicrosoftTeamsChannel::class,
    'level' => 'error',
    'url' => env('LOG_TEAMS_WEBHOOK_URL'),
    'title' => 'My Application'
],
```

then in your `.env` file add:

```env
LOG_TEAMS_WEBHOOK_URL=YOUR_WEBHOOK_URL
```

Send error messages via the Log facade to the teams channel:
```php
\Log::channel('teams')->error('Oh Snap, Stuff broke again!');
```

Or add the teams channel to the default `stack` channel in `config/logging.php`:
```php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'teams'],
    ],
],
```

# TODO
- Make compatible with Section Fields

# License
monolog-microsoft-teams is available under the MIT license. See the LICENSE file for more info.
