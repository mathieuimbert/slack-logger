<?php

namespace MathieuImbert\SlackLogger;

class SlackRequest
{

    private $webhookUrl;

    /**
     * SlackRequest constructor.
     * @param string $webhookUrl
     */
    public function __construct($webhookUrl)
    {
        $this->webhookUrl = $webhookUrl;
    }

    public function post($text)
    {

        /*
        switch ($level) {
            case 'success':
            case 'good':
                $color = 'good';
                break;
            case 'warning':
                $color = 'warning';
                break;
            case 'error':
            case 'danger':
            case 'critical':
                $color = 'danger';
                break;
            case 'info':
                $color = '#3aa3e3';
                break;
            default:
                $color = "#cccccc";
        }
        */

        $payload = [
            "text" => $text
        ];

        $client = new \GuzzleHttp\Client();
        $client->post($this->webhookUrl, ['json' => $payload]);
    }

}