<?php

namespace AppBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;

/**
 * TeamPage
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class TeamPage extends AbstractPage
{

    /**
     * @var string
     *
     * @ORM\Column(name="video_url", type="json_array", nullable=false)
     */
    protected $videoUrl;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $historyTitle;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\CkeditorTranslatable")
     */
    protected $historyDesc;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $teamTitle;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $joinTitle;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\CkeditorTranslatable")
     */
    protected $joinDesc;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $joinUrlLabel;

    public function __construct()
    {
        parent::__construct();

        $this->registerTranslatableField('historyTitle', 'string');
        $this->registerTranslatableField('historyDesc', 'ckeditor');
        $this->registerTranslatableField('teamTitle', 'string');
        $this->registerTranslatableField('joinTitle', 'string');
        $this->registerTranslatableField('joinDesc', 'ckeditor');
        $this->registerTranslatableField('joinUrlLabel', 'string');

    }

    /**
     * @return string
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     * @param string $videoUrl
     */
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }

    /**
     * @return string
     */
    public function getHistoryTitle()
    {
        return $this->historyTitle;
    }

    /**
     * @param string $historyTitle
     */
    public function setHistoryTitle($historyTitle)
    {
        $this->historyTitle = $historyTitle;
    }

    /**
     * @return string
     */
    public function getHistoryDesc()
    {
        return $this->historyDesc;
    }

    /**
     * @param string $historyDesc
     */
    public function setHistoryDesc($historyDesc)
    {
        $this->historyDesc = $historyDesc;
    }

    /**
     * @return string
     */
    public function getTeamTitle()
    {
        return $this->teamTitle;
    }

    /**
     * @param string $teamTitle
     */
    public function setTeamTitle($teamTitle)
    {
        $this->teamTitle = $teamTitle;
    }

    /**
     * @return string
     */
    public function getJoinTitle()
    {
        return $this->joinTitle;
    }

    /**
     * @param string $joinTitle
     */
    public function setJoinTitle($joinTitle)
    {
        $this->joinTitle = $joinTitle;
    }

    /**
     * @return string
     */
    public function getJoinDesc()
    {
        return $this->joinDesc;
    }

    /**
     * @param string $joinDesc
     */
    public function setJoinDesc($joinDesc)
    {
        $this->joinDesc = $joinDesc;
    }

    /**
     * Set joinUrlLabel
     *
     * @param array $joinUrlLabel
     *
     * @return TeamPage
     */
    public function setJoinUrlLabel($joinUrlLabel)
    {
        $this->joinUrlLabel = $joinUrlLabel;

        return $this;
    }

    /**
     * Get joinUrlLabel
     *
     * @return array
     */
    public function getJoinUrlLabel()
    {
        return $this->joinUrlLabel;
    }
}
