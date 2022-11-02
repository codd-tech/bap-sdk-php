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
     * @var Client
     */
    private $client;

    /**
     * @param string $apiKey
     * @param LoggerInterface|null $logger
     */
    public function __construct($apiKey, LoggerInterface $logger = null)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client();
        Log::initialize($logger);
    }

    /**
     * @param array $updates
     * @return void
     */
    public function handleTelegramUpdates(array $updates)
    {
        if (isset($updates['update_id'])) {
            $updates = array($updates);
        }
        if (!isset($updates[0]['update_id'])) {
            Log::error('Invalid input', $updates);
            return;
        }

        $this->client->post('activity', array(
            'api_key' => $this->apiKey,
            'update' => $updates,
        ));
    }
}
