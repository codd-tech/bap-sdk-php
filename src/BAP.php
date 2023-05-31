<?php

namespace CoddTech\Bap;

use Psr\Log\LoggerInterface;

class BAP
{
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
        $this->socket = new UdpSocket('api.production.bap.codd.io', 8081);
        Log::initialize($logger);
    }

    /**
     * @param array $update
     * @return void
     */
    public function handleTelegramUpdates(array $update)
    {
        if (!isset($update['update_id'])) {
            Log::error('Invalid input', $update);
            return;
        }
      
        if (!isset($updates[0]['update_id'])) {
            Log::error('Invalid input', $updates);
            return;
        }

        $this->socket->send(array(
            'api_key' => $this->apiKey,
            'update' => $update,
        ));
    }
}
