<?php

namespace CoddTech\Bap;

use Psr\Log\LoggerInterface;

class BAP
{
    const API_VERSION = 3;
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
            'method' => 'activity',
            'update' => $update,
        ));

        return !$this->isBAPUpdate($update);
    }

    /**
     * @param array $update
     * @return void
     */
    public function advertisement(array $update)
    {
        if (!isset($update['update_id'])) {
            Log::error('Invalid input', $update);
            return;
        }

        if (!$this->isBAPUpdate($update)) {
            $this->socket->send(array(
                'api_key' => $this->apiKey,
                'version' => self::API_VERSION,
                'method' => 'advertisement',
                'update' => $update,
            ));
        }
    }

    protected function isBAPUpdate(array $update)
    {
        if (isset($update['callback_query'], $update['callback_query']['data'])) {
            if (strpos((string)$update['callback_query']['data'], self::BAP_PREFIX) === 0) {
                return true;
            }
        }

        return false;
    }
}
