<?php

namespace Tests\AppBundle\Utils;

/**
 * Utils for call API (GET - POST - PUT - DELETE)
 */
class CurlUtils
{

    // enable debug error message curl
    private $debug = true;
    // token
    private $token;

    /**
     * Generate connection with API - get token
     */
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

    /**
     * Method GET
     * @param  string url
     * @return array response
     */
    public function get($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $this->defineHeaderMethodGet($curl);

        $response = curl_exec($curl);
        return $this->formatResponse($response, $curl);
    }

    /**
     * Method POST
     * @param  string url
     * @param  array data
     * @return array response
     */
    public function post($url, $data) {
        $curl = curl_init();
        $data_string = json_encode($data);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $this->defineHeader($curl);

        $response = curl_exec($curl);
        return $this->formatResponse($response, $curl);
    }

    /**
     * Method PUT
     * @param  string url
     * @param  array data
     * @return array response
     */
    public function put($url, $data) {
        $curl = curl_init();
        $data_string = json_encode($data);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_PUT, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $this->defineHeader($curl);

        $response = curl_exec($curl);
        return $this->formatResponse($response, $curl);
    }

    /**
     * Method DELETE
     * @param  string url
     * @return array response
     */
    public function delete($url) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $this->defineHeader($curl);

        $response = curl_exec($curl);
        return $this->formatResponse($response, $curl);
    }

    /**
     * Define type of request and response for method GET with API
     * Assign token in request
     * @param  Object $curl
     */
    private function defineHeaderMethodGet($curl) {
        $header = array(
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            "Authorization: Bearer " . $this->token
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }

    /**
     * Define type of request and response with API
     * Assign token in request
     * @param  Object $curl
     */
    private function defineHeader($curl) {
        $header = array(
            'Content-Type: application/json',
            "Authorization: Bearer " . $this->token
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }

    /**
     * Format response with CODE and Object of response
     * @param  Object $response
     * @param  Object $curl
     * @return array response
     */
    private function formatResponse($response, $curl) {
        $result = json_decode($response, true);
        // if debug return error message
        if ($this->debug && array_key_exists('error', $result)) {
            var_dump($result['error']['exception']);
        }
        // format response
        $tab = array(
            'HTTP_CODE' => curl_getinfo($curl)['http_code'],
            'RESPONSE' => $result
        );
        return $tab;
    }

}
