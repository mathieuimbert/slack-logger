<?php


namespace MathieuImbert\SlackLogger;


use GuzzleHttp\Psr7\Response;

interface RequestInterface
{

    /**
     * @param string $url
     * @param mixed $payload
     * @return mixed
     */
    public function post($url, $payload);

    /**
     * @return Response
     */
    public function getResponse();
}
