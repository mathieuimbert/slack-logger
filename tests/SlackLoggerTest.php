<?php


namespace MathieuImbert\SlackLogger\Tests;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use MathieuImbert\SlackLogger\SlackLogger;
use Psr\Log\LogLevel;

class SlackLoggerTest extends TestCase
{

    public function testLog()
    {
        $logger = new SlackLogger(getenv('WEBHOOK_URL'));
        $logger->log(LogLevel::INFO, 'Testing from PHPUnit');
    }

    public function testUnit()
    {
        $mock = new MockHandler([
            new Response(200),
            new Response(500)
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $logger = new SlackLogger(getenv('WEBHOOK_URL'), [], $client);
        $logger->log(LogLevel::INFO, 'Testing from PHPUnit');
    }
}