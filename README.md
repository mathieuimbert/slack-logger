# slack-logger
This is a simple package that allow a PHP script to send real time to Slack.

## Installation ##

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