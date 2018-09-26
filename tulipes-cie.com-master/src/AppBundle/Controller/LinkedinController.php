<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LinkedinController extends Controller
{
    const TOKEN_CACHE_KEY = 'linkedin.access_token';
    const FEED_CACHE_KEY  = 'app.feed';

    /**
     * @Route("/linkedin", name="linkedin_authorization")
     */
    public function setAccessToken(Request $request)
    {
        $linkedIn = $this->container->get('happyr.linkedin');
        if ($linkedIn->isAuthenticated()) {
            $token = $linkedIn->getAccessToken();

            $cache = new FilesystemCache();
            $cache->set(self::TOKEN_CACHE_KEY, $token);
            $cache->delete(self::FEED_CACHE_KEY);

            $test = $this->testAccessToken();
            if ($test != null){
                return $this->render('AppBundle:Admin:error_linkedin_access.html.twig', [
                    'msg_error' => $test,
                ]);
            }

        } else if ($linkedIn->hasError()) {
            throw new BadRequestHttpException("User canceled the login.");
        }

        return $this->redirectToRoute('admin_app_page_abstractpage_list');
    }

    public function getAccessToken()
    {
        $cache = new FilesystemCache();
        return $cache->get(self::TOKEN_CACHE_KEY);
    }

    public function testAccessToken()
    {
        $msg_error = null;

        $linkedIn = $this->container->get('happyr.linkedin');
        $companyId = $this->container->getParameter('linkedin_company_id');

        $token = $this->getAccessToken();
        if (!$token) {
            $msg_error = "Le token d'accés n'a pas été générer.";
        }
        $linkedIn->setAccessToken($token);

        $response = $linkedIn->get('v1/companies/'. $companyId .'/updates');
        if (isset($response['message'])) {
            $msg_error = $response['message'];
            $msg_error .= "<br>Veuiller essayer avec un autre compte LinkedIn.";
        }

        return $msg_error;
    }


}