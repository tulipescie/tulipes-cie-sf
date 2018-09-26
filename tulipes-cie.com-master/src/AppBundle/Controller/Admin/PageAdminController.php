<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageAdminController extends CRUDController
{

    public function generateInstagramAccessTokenAction()
    {
        $clientId = $this->container->getParameter('instagram_api_key');
        $url = "https://api.instagram.com/oauth/authorize/?" . http_build_query([
                'client_id' => $clientId,
                'response_type' => 'token',
                'scope' => 'public_content',
                'redirect_uri' => $this->generateUrl('instagram_authorization', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

        return $this->redirect($url);
    }

    public function generateLinkedinAccessTokenAction()
    {
        $linkedIn = $this->container->get('happyr.linkedin');

        $option = [
            'redirect_uri' => $this->generateUrl('linkedin_authorization', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ];
        $url = $linkedIn->getLoginUrl($option);

        return $this->redirect($url);
    }

}