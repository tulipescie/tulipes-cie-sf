<?php

namespace AppBundle\Controller;

use AppBundle\Exceptions\InstagramNotFoundAccessTokenException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Simple\FilesystemCache;

class InstagramController extends Controller
{

    const TOKEN_CACHE_KEY = 'instagram.access_token';
    const FEED_CACHE_KEY  = 'app.feed';

    /**
     * @Route("/instagram", name="instagram_authorization")
     */
    public function getAccessByJavaScript()
    {
        return $this->render('instagram/access-token.html.twig');
        
    }

    /**
     * @Route("/instagram/access_token", name="instagram_access_token")
     */
    public function setAccessToken(Request $request)
    {
        $token = $request->query->get('token');

        if ($token != null) {
            $cache = new FilesystemCache();
            $cache->set(self::TOKEN_CACHE_KEY, $token);
            $cache->delete(self::FEED_CACHE_KEY);
        }
        return $this->redirectToRoute('admin_app_page_abstractpage_list');
    }
}