<?php

namespace AppBundle\Utils;

class RecaptchaValidator
{
    private $key;
    private $secret;
    private $response;
    private $remoteIp;

    private static $url = 'https://www.google.com/recaptcha/api/siteverify';

    function __construct($key, $secret, $response, $remoteIp = null)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->response = $response;
        $this->remoteIp = $remoteIp;
    }

    public function check()
    {
        if ($this->key && $this->secret && $this->response) {
            $response = $this->doRequest();

            if (array_key_exists('success', $response) && $response['success'] === true) {
                return true;
            }

            return false;
        }

        return false;
    }

    private function doRequest()
    {
        $handle = curl_init(static::$url);

        $options = [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $this->getQueryString(),
            CURLOPT_HTTPHEADER     => ["Content-Type: application/x-www-form-urlencoded"],
            CURLINFO_HEADER_OUT    => false,
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_RETURNTRANSFER => true,
        ];

        curl_setopt_array($handle, $options);
        $response = curl_exec($handle);

        if ($response === false) {
            $this->handleCurlError($handle);
        }
        curl_close($handle);

        return json_decode($response, true);
    }

    private function getQueryString()
    {
        $data = [
            'secret'   => $this->secret,
            'response' => $this->response,
        ];

        if ($this->remoteIp) {
            $data['remoteip'] = $this->remoteIp;
        }

        return http_build_query($data, "", "&");
    }

    protected function handleCurlError($curlRessource)
    {
        throw new \ErrorException(sprintf(
            "Curl Error %s: %s",
            curl_errno($curlRessource),
            curl_error($curlRessource)
        ));
    }
}
