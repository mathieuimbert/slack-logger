# slack-logger

### Packagist

[![Latest Stable Version](https://poser.pugx.org/mathieuimbert/slack-logger/v/stable)](https://packagist.org/packages/mathieuimbert/slack-logger)
[![Latest Unstable Version](https://poser.pugx.org/mathieuimbert/slack-logger/v/unstable)](https://packagist.org/packages/mathieuimbert/slack-logger)
[![Total Downloads](https://poser.pugx.org/mathieuimbert/slack-logger/downloads)](https://packagist.org/packages/mathieuimbert/slack-logger)
[![License](https://poser.pugx.org/mathieuimbert/slack-logger/license)](https://packagist.org/packages/mathieuimbert/slack-logger)

### Unit Tests

[![Build Status](https://travis-ci.org/mathieuimbert/slack-logger.svg?branch=master)](https://travis-ci.org/mathieuimbert/slack-logger)
[![Coverage Status](https://coveralls.io/repos/github/mathieuimbert/slack-logger/badge.svg?branch=master)](https://coveralls.io/github/mathieuimbert/slack-logger?branch=master)

### Code Quality

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/7c2c822d-857f-4b69-874d-d4e78b9d1e24/big.png)](https://insight.sensiolabs.com/projects/7c2c822d-857f-4b69-874d-d4e78b9d1e24)

## Description

This is a simple package that allow a PHP script to send real time logs to Slack.

Please be aware that the repository is still in an early phase, and every new commit might not be backward compatible.

## Installation

Installation of Slack Logger is done using [Composer](https://getcomposer.org/).

```
composer require mathieuimbert/slack-logger
```

## Usage ##

- Create an [Incoming Webhook](https://my.slack.com/services/new/incoming-webhook/) for your slack account. Make sure to read the [full documentation](https://api.slack.com/incoming-webhooks)
- Instantiate SlackLogger in your script, and start sending logs to Slack
 
```php
$logger = new \MathieuImbert\Slack\Logger\SlackLogger('https://hooks.slack.com/services/xxxxxxx/xxxxxxx/xxxxxxx');
$logger->warning('This a not test of the emergency broadcast system, this is the real thing');
```

### Options ###

You can customize the name and the icon of your logger in the incoming webhook configuration, or you can do it from SlackLogger by passing the right options to he constructor:

```php
$logger = new \MathieuImbert\SlackLogger\SlackLogger(
    'https://hooks.slack.com/services/xxxxxxx/xxxxxxx/xxxxxxx',
    array('username' => 'My Slack Logger', 'icon_emoji' => ':cop:')
);
```
