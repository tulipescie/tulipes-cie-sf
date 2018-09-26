<?php

namespace AppBundle\Utils;


use AppBundle\Exceptions\FacebookException;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\FacebookRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use GuzzleHttp\Psr7\Request;

class Facebook
{
    private $fbAppId;
    private $fbAppSecret;
    private $pageId;

    private $connection;

    const DEFAULT_GRAPH_VERSION  = 'v2.8';

    public function __construct($fbAppId, $fbAppSecret, $pageId)
    {
        $this->fbAppId     = $fbAppId;
        $this->fbAppSecret = $fbAppSecret;
        $this->pageId = $pageId;

        $this->validConnection();
    }

    private function validConnection()
    {
        try {
            $this->connection = new \Facebook\Facebook([
                'app_id' => $this->fbAppId,
                'app_secret' => $this->fbAppSecret,
                'default_graph_version' => self::DEFAULT_GRAPH_VERSION,
            ]);

        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return $this;
    }

    /**
     *
     *   Get posts of graph
     *
     *   @param  Graph $graph
     *
     *   @return Array of posts
     */
    private function getItems($graph)
    {
        $list = [];
        foreach ($graph as $post) {
            $list[] = $post->asArray();
        }
        return $list;
    }

    /**
     *
     *   Handler of response api
     *
     *   @param  String $method method to call in facebook's api
     *   @param  array $args parameters for request

     *   @throws FacebookException on request exception or response error
     *
     *   @return Object parsed response of api
     */
    private function callFacebookAPI($method, $args = [])
    {
        $args['access_token'] = $this->fbAppId .'|'. $this->fbAppSecret;
        $path = $method . '?' . http_build_query($args);

        try {
            $results = $this->connection->get($path);
        } catch (\Exception $e) {
            throw new HttpException(404,
                sprintf('Error on requesting api : %s (%s)', $e->getMessage(), $e->getCode()));
        }

        return $results->getGraphEdge();
    }

    /**
     *   Get all posts of user authentified.
     *
     *   @param $limit
     *   @return Array of posts
     */
    public function getPost($limit=10)
    {

        set_time_limit(-1);
        $posts = [];

        $args = [
            'limit'  => $limit,
            'fields' => 'id, message, description, link, permalink_url, properties, created_time, full_picture'

        ];

        $graph = $this->callFacebookAPI('/'. $this->pageId .'/feed', $args);


        $posts = array_merge($posts, $this->getItems($graph));

        return $posts;
    }

    private function fetchUrl($url){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }

    public function getAccessToken()
    {
        $token = $this->fetchUrl("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id=". $this->fbAppId ."&client_secret=". $this->fbAppSecret);
        $token = json_decode($token);
        return $token->access_token;
    }

    public function getToken()
    {
        $fbApp = new \Facebook\Facebook([
            'app_id' => $this->fbAppId,
            'app_secret' => $this->fbAppSecret,
            'default_graph_version' => self::DEFAULT_GRAPH_VERSION,
        ]);

        $req = $fbApp->getDefaultAccessToken();

        return $req;
    }


    public function getPostWithCurl($limit=10)
    {
        $url = "https://graph.facebook.com/v2.10/me/feed";

        $args = [
            'access_token' => 'EAACEdEose0cBAKt4sGL34rg4mnj3PIlxToi9l2GVnmOMQfn2sg6icVsZBqpNfElAJ41cn2JDAcmmcOGrojj3Uw3hgirXhrFnGYclbdx6LIEv2eHvq4AiUKvoZA70cy1PUgGFfJiNyZAkdtM1X9U6DhZCEJmr8T3RawGDnrBN4CTD4UTlI8LnGgaB4yfloYNXMrzMRepHUAZDZD',
            'limit'  => $limit,
            'fields' => 'id, message, description, link, permalink_url, properties, created_time, full_picture'
        ];

        $request = $this->fetchUrl($url . '?' . http_build_query($args));
        $res = json_decode($request);
        return $res;
    }



}