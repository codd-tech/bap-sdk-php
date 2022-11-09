<?php

namespace CoddTech\Bap;

class UdpSocket
{
    /**
     * @var false|resource|\Socket
     */
    private $socket;
    /**
     * @var string
     */
    private $address;
    /**
     * @var int
     */
    private $port;

    /**
     * @param string $address
     * @param int $port
     */
    public function __construct($address, $port)
    {
        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        $this->address = $address;
        $this->port = $port;
    }

    public function send(array $arr)
    {
        $data = json_encode($arr);
        socket_sendto($this->socket, $data, strlen($data), 0, $this->address, $this->port);
    }
}
