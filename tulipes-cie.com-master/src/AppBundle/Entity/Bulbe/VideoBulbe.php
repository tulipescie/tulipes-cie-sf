<?php

namespace AppBundle\Entity\Bulbe;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Caramia\MediaBundle\Annotation\MediaConstraints as MediaAssert;

/**
 * VideoBulbe
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class VideoBulbe extends AbstractBulbe
{
    /**
     * @var \AppBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="video_bulbe_thumb", referencedColumnName="id", nullable=true)
     * })
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $videoBulbeThumb;

    /**
     * @var string
     *
     * @ORM\Column(name="video_bulbe_url", type="json_array", nullable=false)
     */
    protected $videoBulbeUrl;

    /**
     * @return \AppBundle\Entity\Media
     */
    public function getVideoBulbeThumb()
    {
        return $this->videoBulbeThumb;
    }

    /**
     * @param \AppBundle\Entity\Media $videoBulbeThumb
     */
    public function setVideoBulbeThumb($videoBulbeThumb)
    {
        $this->videoBulbeThumb = $videoBulbeThumb;
    }

    /**
     * @return string
     */
    public function getVideoBulbeUrl()
    {
        return $this->videoBulbeUrl;
    }

    /**
     * @param string $videoBulbeUrl
     */
    public function setVideoBulbeUrl($videoBulbeUrl)
    {
        $this->videoBulbeUrl = $videoBulbeUrl;
    }


}