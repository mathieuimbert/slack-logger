<?php


namespace MathieuImbert\SlackLogger\Tests;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MathieuImbert\SlackLogger\SlackRequest;
use PHPUnit\Framework\TestCase;
use MathieuImbert\SlackLogger\SlackLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

class SlackLoggerTest extends TestCase
{

    public function testLog()
    {
        $url = getenv('WEBHOOK_URL');
        if (!$url) {
            return;
        }

        $logger = new SlackLogger(getenv('WEBHOOK_URL'));
        $logger->log(LogLevel::INFO, 'Testing from PHPUnit');

        $this->assertEquals('ok', $logger->getRequest()->getResponse()->getBody()->getContents());
    }

    public function testUnit()
    {
        $mock = new MockHandler([
            new Response(200, [], 'ok')
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $logger = new SlackLogger('', [], new SlackRequest($client));
        $logger->log(LogLevel::INFO, 'Testing from PHPUnit');

        $this->assertEquals(200, $logger->getRequest()->getResponse()->getStatusCode());
        $this->assertEquals('ok', $logger->getRequest()->getResponse()->getBody()->getContents());
    }

    public function testInvalidLevel()
    {
        $this->expectException(InvalidArgumentException::class);

        $logger = new SlackLogger('', []);
        $logger->log('invalid', 'test');
    }

    private function getMockRequest()
    {
        // Create a mock for the Observer class,
        // only mock the update() method.
        $request = $this->getMockBuilder(SlackRequest::class)
            ->setConstructorArgs(array(new Client()))
            ->setMethods(['post'])
            ->getMock();

        // Set up the expectation for the update() method
        // to be called only once and with the string 'something'
        // as its parameter.
        $request->expects($this->once())
            ->method('post');

        return $request;
    }

    public function testDebug()
    {
        $logger = new SlackLogger('http://example.com/', [], $this->getMockRequest());
        $logger->debug('This is a debug');
    }

    public function testInfo()
    {
        $logger = new SlackLogger('http://example.com/', [], $this->getMockRequest());
        $logger->info('This is an info');
    }

    public function testNotice()
    {
        $logger = new SlackLogger('http://example.com/', [], $this->getMockRequest());
        $logger->notice('This is a notice');
    }

    public function testWarning()
    {
        $logger = new SlackLogger('http://example.com/', [], $this->getMockRequest());
        $logger->warning('This is a warning');
    }

    public function testError()
    {
        $logger = new SlackLogger('http://example.com/', [], $this->getMockRequest());
        $logger->error('This is a error');
    }

    public function testCritical()
    {
        $logger = new SlackLogger('http://example.com/', [], $this->getMockRequest());
        $logger->critical('This is a critical error');
    }

    public function testAlert()
    {
        $logger = new SlackLogger('http://example.com/', [], $this->getMockRequest());
        $logger->alert('This is an alert');
    }

    public function testEmergency()
    {
        $logger = new SlackLogger('http://example.com/', [], $this->getMockRequest());
        $logger->emergency('This is an emergency');
    }

    public function testLogWithMockRequest()
    {
        $logger = new SlackLogger('http://example.com/', [], $this->getMockRequest());
        $logger->log(LogLevel::NOTICE, 'This is an emergency');
    }
}
