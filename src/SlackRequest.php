<?php


namespace MathieuImbert\SlackLogger;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class SlackRequest implements RequestInterface
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Response
     */
    protected $response = null;

    /**
     * SlackRequest constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Port the request to Slack. Returns true if success, false if failure.
     * Response body and code are available in
     *
     * @param string $url
     * @param array $jsonPayload
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($url, $jsonPayload)
    {
        $this->response = $this->client->post($url, array('json' => $jsonPayload));
        return $this->response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
