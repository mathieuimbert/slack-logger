<?php


namespace MathieuImbert\SlackLogger;


use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class SlackLogger implements LoggerInterface
{

    const SUPPORTED_OPTIONS = array('username', 'icon_emoji');

    /**
     * @var string
     */
    private $webhookUrl;

    /**
     * @var array
     */
    private $options;

    /**
     * @var Client
     */
    private $client;

    /**
     * SlackLogger constructor
     *
     * @param string $webhookUrl
     * @param array $options
     * @param Client $client
     */
    public function __construct($webhookUrl, $options = [], Client $client = null)
    {
        $this->webhookUrl = $webhookUrl;
        $this->options = $options;

        if (is_null($client)) {
            $client = new Client();
        }

        $this->client = $client;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {

        $fields = array();

        if (!empty($context)) {

            // Check if there is an exception (as required in psr3 documentation)
            if (isset($context['exception']) && is_a($context['exception'], 'Exception')) {
                $fields[] = array(
                    'title' => 'Exception',
                    'value' => get_class($context['exception']) . ': ' . $context['exception']->getMessage(),
                    'short' => true
                );

                unset($context['exception']);
            }

            $fields[] = array(
                'title' => 'Context',
                'value' => json_encode($context, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'short' => true
            );
        }

        $text = '*' . ucfirst($level) . '*' . ' - ' . $message;

        $payload = array(
            'attachments' => array(
                array(
                    'fallback' => $message,
                    'color' => $this->getColorForLevel($level),
                    'text' => $text,
                    'fields' => $fields,
                    'mrkdwn_in' => array('text')
                )
            )
        );

        foreach (self::SUPPORTED_OPTIONS as $opt) {
            if (isset($this->options[$opt])) {
                $payload[$opt] = $this->options[$opt];
            }
        }

        $this->client->post($this->webhookUrl, array('json' => $payload));
    }

    /**
     * Return the right icon for the message level
     *
     * @param string $level
     * @return bool|mixed
     */
    protected function getIconForLevel($level)
    {
        $conversion = array(
            LogLevel::INFO => ':information_source:',
            LogLevel::NOTICE => ':memo:',
            LogLevel::WARNING => ':warning:',
            LogLevel::ERROR => ':exclamation:',
            LogLevel::ALERT => ':bangbang:',
            LogLevel::CRITICAL => ':bangbang:',
            LogLevel::EMERGENCY => ':sos:',
        );

        return isset($conversion[$level]) ? $conversion[$level] : false;
    }

    /**
     * @param $level
     * @return bool|string
     */
    protected function getColorForLevel($level)
    {
        $conversion = array(
            LogLevel::DEBUG => '',
            LogLevel::INFO => '#439FE0',
            LogLevel::NOTICE => '#439FE0',
            LogLevel::WARNING => 'warning',
            LogLevel::ERROR => 'danger',
            LogLevel::ALERT => 'danger',
            LogLevel::CRITICAL => 'danger',
            LogLevel::EMERGENCY => 'danger',
        );

        return isset($conversion[$level]) ? $conversion[$level] : false;
    }
}
