<?php

namespace Tests\AppBundle\Utils;

/**
 * Utils for call API (GET - POST)
 */
class CurlUtils
{

    private $token;

    public function connect($url) {
        $curl = curl_init();
        $data = array('_username' => 'test@test.fr', '_password' => 'p@ssword');

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        $this->token = $data['token'];
    }

    public function get($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $this->addTokenToHeader($curl);

        $response = curl_exec($curl);
        return $this->formatResponse($response, $curl);
    }

    public function post($url, $data) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $this->addTokenToHeader($curl);

        $response = curl_exec($curl);
        return $this->formatResponse($response, $curl);
    }

    private function addTokenToHeader($curl) {
        $header = array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            "Authorization: Bearer " . $this->token
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }

    private function formatResponse($response, $curl) {
        $result = json_decode($response, true);
        $tab = array(
            'HTTP_CODE' => curl_getinfo($curl)['http_code'],
            'RESPONSE' => $result
        );
        return $tab;
    }

}
