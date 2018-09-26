<?php

namespace AppBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgencyPage
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class AgencyPage extends AbstractPage
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
    protected $visionTitle;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $figureTitle;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\TextTranslatable")
     */
    protected $figureDescription;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $numberTitle;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $customerTitle;


    public function __construct()
    {
        parent::__construct();

        $this->registerTranslatableField('visionTitle', 'string');
        $this->registerTranslatableField('figureTitle', 'string');
        $this->registerTranslatableField('figureDescription', 'text');
        $this->registerTranslatableField('numberTitle', 'string');
        $this->registerTranslatableField('customerTitle', 'string');
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
    public function getVisionTitle()
    {
        return $this->visionTitle;
    }

    /**
     * @param string $visionTitle
     */
    public function setVisionTitle($visionTitle)
    {
        $this->visionTitle = $visionTitle;
    }

    /**
     * @return string
     */
    public function getFigureTitle()
    {
        return $this->figureTitle;
    }

    /**
     * @param string $figureTitle
     */
    public function setFigureTitle($figureTitle)
    {
        $this->figureTitle = $figureTitle;
    }

    /**
     * @return string
     */
    public function getFigureDescription()
    {
        return $this->figureDescription;
    }

    /**
     * @param string $figureDescription
     */
    public function setFigureDescription($figureDescription)
    {
        $this->figureDescription = $figureDescription;
    }

    /**
     * @return string
     */
    public function getNumberTitle()
    {
        return $this->numberTitle;
    }

    /**
     * @param string $numberTitle
     */
    public function setNumberTitle($numberTitle)
    {
        $this->numberTitle = $numberTitle;
    }

    /**
     * @return string
     */
    public function getCustomerTitle()
    {
        return $this->customerTitle;
    }

    /**
     * @param string $customerTitle
     */
    public function setCustomerTitle($customerTitle)
    {
        $this->customerTitle = $customerTitle;
    }


}
