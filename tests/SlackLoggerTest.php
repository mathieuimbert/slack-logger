<?php


namespace MathieuImbert\SlackLogger\Tests;


use PHPUnit\Framework\TestCase;
use MathieuImbert\SlackLogger\SlackLogger;
use Psr\Log\LogLevel;

class SlackLoggerTest extends TestCase
{

    public function testLog()
    {
        $logger = new SlackLogger($_ENV['WEBHOOK_URL']);
        $logger->log(LogLevel::INFO, 'Testing from PHPUnit');
    }
}