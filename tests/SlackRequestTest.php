<?php


namespace MathieuImbert\SlackLogger\Tests;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MathieuImbert\SlackLogger\SlackRequest;
use PHPUnit\Framework\TestCase;

class SlackRequestTest extends TestCase
{

    public function testPost()
    {
        $mock = new MockHandler([
            new Response(200, [], 'ok')
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $request = new SlackRequest($client);
        $response = $request->post('', []);

        $this->assertNotNull($response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('ok', $response->getBody());
    }
}
