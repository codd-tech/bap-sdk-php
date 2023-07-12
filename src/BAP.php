<?php

namespace CoddTech\Bap;

use Psr\Log\LoggerInterface;

class BAP
{
    const API_VERSION = 2;
    const BAP_PREFIX = '/__bap';

    /**
     * @var string
     */
    private $apiKey;
    /**
     * @var UdpSocket
     */
    private $socket;

    /**
     * @param string $apiKey
     * @param LoggerInterface|null $logger
     */
    public function __construct($apiKey, LoggerInterface $logger = null)
    {
        $this->apiKey = $apiKey;
        $this->socket = new UdpSocket('api.production.bap.codd.io', 8080);
        Log::initialize($logger);
    }

    /**
     * @param array $update
     * @return bool continue request handling or not
     */
    public function handleTelegramUpdates(array $update)
    {
        if (!isset($update['update_id'])) {
            Log::error('Invalid input', $update);
            return true;
        }

        $this->socket->send(array(
            'api_key' => $this->apiKey,
            'version' => self::API_VERSION,
            'update' => $update,
        ));

        if (isset($update['callback_query'], $update['callback_query']['data'])) {
            if (strpos((string)$update['callback_query']['data'], self::BAP_PREFIX) === 0) {
                return false;
            }
        }

        return true;
    }
}
