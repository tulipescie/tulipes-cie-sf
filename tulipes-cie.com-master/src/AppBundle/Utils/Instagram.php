<?php

namespace AppBundle\Utils;


use AppBundle\Exceptions\InstagramNotFoundAccessTokenException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

class Instagram
{
    const API_OAUTH_URL = 'https://api.instagram.com/oauth/authorize';
    const TOKEN_CACHE_KEY = 'instagram.access_token';

    public function getAccessToken()
    {
        $cache = new FilesystemCache();
        return $cache->get(self::TOKEN_CACHE_KEY);
    }

    public function getMedia($limit = 10)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            throw new InstagramNotFoundAccessTokenException("Instagram Access Token Not Found");
        }

        $args = [
            'access_token'  => $token,
            'count'         => $limit,
        ];

        $url = sprintf(
            'https://api.instagram.com/v1/users/self/media/recent?%s',
            http_build_query($args)
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL              , $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER   , true);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new \Exception("Error Processing Request with curl");
        }

        $response = json_decode($response, true);

        if ($response === false) {
            throw new \Exception("Error decoding request");
        }

        if ($response['meta']['code'] == '400') {
            throw new InstagramNotFoundAccessTokenException(['meta']['message']);
        }

        return $response['data'];
    }


}