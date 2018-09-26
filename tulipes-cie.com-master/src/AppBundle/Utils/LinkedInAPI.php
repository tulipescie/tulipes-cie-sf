<?php

namespace AppBundle\Utils;

use Happyr\LinkedIn\LinkedIn;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LinkedInAPI
 * @package AppBundle\Utils
 * @doc https://github.com/Happyr/LinkedInBundle
 */
class LinkedInAPI
{

    private $linkedIn;
    private $container;

    const TOKEN_CACHE_KEY = 'linkedin.access_token';

    /**
     * LinkedIn constructor.
     * @param $linkedIn
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->linkedIn = $this->container->get('happyr.linkedin');
    }

    public function getAccessToken()
    {
        $cache = new FilesystemCache();
        return $cache->get(self::TOKEN_CACHE_KEY);
    }

    public function getCompanyProfil($companyId)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            throw new BadRequestHttpException("Linkedin Access Token Not Found");
        }
        $this->linkedIn->setAccessToken($token);

        $response = $this->linkedIn->get('v1/companies/'. $companyId .'/updates');
        if (isset($response['message'])) {
            throw new BadRequestHttpException($response['message']);
        }
        return $response;

    }
}