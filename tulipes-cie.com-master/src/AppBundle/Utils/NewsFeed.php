<?php

namespace AppBundle\Utils;

use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Utils\Facebook;
use AppBundle\Utils\Twitter;
use AppBundle\Utils\LinkedInAPI;
use Symfony\Component\HttpFoundation\Session\Session;

class NewsFeed
{
    private $appFeed;
    private $container;
    private $cache;
    private $session;

    const FEED_LIMIT        = 10;
    const TEXT_LENGTH       = 110;
    const FEED_CACHE_KEY    = 'app.feed';
    const FEED_COOKIE_NAME = 'feed_valide';

    /**
     * NewsFeed constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->appFeed   = [];
        $this->container = $container;
        $this->cache     = new FilesystemCache();
    }

    /**
     * @return array
     */
    public function getAppFeed()
    {

        if (isset($_COOKIE[self::FEED_COOKIE_NAME])
            && $this->cache->has(self::FEED_CACHE_KEY)) {

            return $this->cache->get(self::FEED_CACHE_KEY);

        } else {
            $this->saveFeedInCache();
            return $this->cache->get(self::FEED_CACHE_KEY);
        }
    }

    protected function saveFeedInCache() {
        $this->getFacebookFeed();
        $this->getTwitterFeed();
        $this->getLinkedFeed();
        $this->getInstagramFeed();

        //trie des flux par date
        usort($this->appFeed, array($this, 'sortFunction'));

        $this->cache->set(self::FEED_CACHE_KEY, $this->appFeed);
        setcookie(self::FEED_COOKIE_NAME, true, time() + 3*3600);

        return $this;
    }

    /**
     * sort's Callback
     *
     * @return $B - $A
     */
    function sortFunction( $a, $b ) {
        $tA = strtotime($a['created_at']->format('Y-m-d H:i:s'));
        $tB = strtotime($b['created_at']->format('Y-m-d H:i:s'));

        return $tB - $tA;
    }

    private function addNews($source, $createdAt, $text, $image = null, $link)
    {
        $news = [
            'source'      => $source,
            'created_at'  => $createdAt,
            'text'        => $text,
            'image'       => $image,
            'link'        => $link,
        ];

        $this->appFeed[] = $news;

        return $this;
    }

    /**
     * @return NewsFeed Instagram's Feed
     */
    protected function getFacebookFeed()
    {
        $fbKey = $this->container->getParameter('facebook_api_key');
        $fbSecret = $this->container->getParameter('facebook_api_secret');
        $fbPageId = $this->container->getParameter('facebook_page_id');
        $facebook = new Facebook($fbKey, $fbSecret, $fbPageId);
        $feedFb = $facebook->getPost(self::FEED_LIMIT + 3);

        foreach ($feedFb as $feed) {
            if (!empty($feed['message'])) {
                $createdAt = $feed['created_time'];
                $text      = empty($feed['message']) ? null : substr($feed['message'], 0, self::TEXT_LENGTH);
                $image     = empty($feed['full_picture']) ? null : $feed['full_picture'];
                $link      = $feed['permalink_url'];

                $this->addNews("Facebook", $createdAt, $text, $image, $link);
            }
        }

        return $this;
    }

    /**
     * @return NewsFeed Twitter's Feed
     */
    protected function getTwitterFeed()
    {
        $clientKey = $this->container->getParameter('twitter_api_key');
        $clientSecret = $this->container->getParameter('twitter_api_secret');
        $clientName = $this->container->getParameter('twiter_owner');
        $twitter = new Twitter($clientKey, $clientSecret);
        $twitterFeed = $twitter->lastTweets($clientName, self::FEED_LIMIT + 2);

        foreach ($twitterFeed as $tweet) {
            $text = substr($tweet->text, 0, self::TEXT_LENGTH);
            $createdAt = new \DateTime($tweet->created_at);
            $link = "https://twitter.com/statuses/" . $tweet->id;

            $this->addNews("Twitter", $createdAt, $text, null, $link);
        }

        return $this;
    }

    /**
     * @return NewsFeed LinkedIn's Feed
     */
    protected function getLinkedFeed()
    {

        $companyId = $this->container->getParameter('linkedin_company_id');

        try {
            $linkedIn     = new LinkedInAPI($this->container);
            $linkedInFeed = $linkedIn->getCompanyProfil($companyId);
        } catch (\Exception $e) {
            return null;
        }

        foreach ($linkedInFeed['values'] as $feed) {
            $article = $feed['updateContent']['companyStatusUpdate']['share'];

            $timestamp = substr($article['timestamp'], 0 , 10);
            $createdAt = new \DateTime();
            $createdAt->setTimestamp($timestamp);

            $text = substr($article['comment'], 0, self::TEXT_LENGTH);

            $image = empty($article['content'])? null: $article['content']['submittedImageUrl'];

            $feedIdPulic = explode("-", $feed['updateKey'])[2];
            $link = "https://www.linkedin.com/feed/update/urn:li:activity:" . $feedIdPulic;

            $this->addNews("LinkedIn", $createdAt, $text, $image, $link);
        }

        return $this;
    }

    /**
     * @return NewsFeed Instagram's Feed
     */
    protected function getInstagramFeed()
    {
        $instagram = new Instagram();
        try {
            $feedInsta = $instagram->getMedia(self::FEED_LIMIT + 2);
        } catch (\Exception $e) {
            return null;
        }

        foreach ($feedInsta as $key => $feed) {
            $text = substr(strip_tags($feed['caption']['text']), 0, self::TEXT_LENGTH);
            $image = $feed['images']['standard_resolution']['url'];
            $createdAt = new \DateTime();
            $createdAt->setTimestamp($feed['created_time']);
            $link = $feed['link'];

            $this->addNews("Instagram", $createdAt, $text, $image, $link);
        }

        return $this;
    }
}