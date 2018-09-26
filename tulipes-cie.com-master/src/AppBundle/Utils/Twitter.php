<?php

namespace AppBundle\Utils;

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter
{
    private $consumerKey;
    private $consumerSecret;

    /**
     * Twitter constructor.
     * @param $consumerKey
     * @param $consumerSecret
     */
    public function __construct($consumerKey, $consumerSecret)
    {
        $this->consumerKey    = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }

    private function getAppAccessToken() {
        $oauth = new TwitterOAuth($this->consumerKey, $this->consumerSecret);
        $accessToken = $oauth->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);
        return $accessToken->access_token;
    }

    public function lastTweets($screenName, $limit=10)
    {
        $twitter = new TwitterOAuth($this->consumerKey, $this->consumerSecret, null, $this->getAppAccessToken());
        $tweets = $twitter->get('statuses/user_timeline', [
            'screen_name' => $screenName,
            'exclude_replies' => true,
            'count' => $limit,
        ]);

        return array_slice($tweets, 0, $limit);
    }
}