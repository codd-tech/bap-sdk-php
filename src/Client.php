<?php

namespace CoddTech\Bap;

/**
 * @internal
 */
class Client
{
    const API_BASE_PATH = 'https://api.stage.bap.codd.io/api';

    public function post($path, array $data = array(), array $options = array())
    {
        $path = '/' . ltrim($path, '/');
        $options = array_replace(array(
            CURLOPT_POST => true,
            CURLOPT_URL => self::API_BASE_PATH . $path,
            CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            CURLOPT_POSTFIELDS => json_encode($data),
        ), $options);
        $this->call($options);
    }

    public function call(array $options)
    {
        $options = array_replace(array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 1,
        ), $options);

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $curlResponse = curl_exec($ch);
        if ($curlResponse === false) {
            $curlErrno = curl_errno($ch);
            $curlError = curl_error($ch);
            Log::warning('Curl error', array(
                'code' => $curlErrno,
                'error' => $curlError
            ));
        } else {
            Log::debug(__CLASS__, array('response' => $curlResponse));
        }
    }
}
