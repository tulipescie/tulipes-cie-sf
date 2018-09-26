<?php

namespace AppBundle\Entity\Bulbe;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Caramia\MediaBundle\Annotation\MediaConstraints as MediaAssert;

/**
 * FavoriteBulbe
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class FavoriteBulbe extends AbstractBulbe
{
    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\TextTranslatable")
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="favorite_bulbe_url", type="json_array", nullable=false)
     */
    protected $favoriteBulbeUrl;

    /**
     * @var \AppBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bulbe_thumb1_image", referencedColumnName="id", nullable=true)
     * })
     * @Assert\NotBlank(),
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $thumb1Image;

    /**
     * @var \AppBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bulbe_thumb2_image", referencedColumnName="id", nullable=true)
     * })
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $thumb2Image;

    /**
     * @var \AppBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bulbe_thumb3_image", referencedColumnName="id", nullable=true)
     * })
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $thumb3Image;

    /**
     * @var \AppBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bulbe_thumb4_image", referencedColumnName="id", nullable=true)
     * })
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $thumb4Image;


    public function __construct()
    {
        parent::__construct();

        $this->registerTranslatableField('description', 'text');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getFavoriteBulbeUrl()
    {
        return $this->favoriteBulbeUrl;
    }

    /**
     * @param string $favoriteBulbeUrl
     */
    public function setFavoriteBulbeUrl($favoriteBulbeUrl)
    {
        $this->favoriteBulbeUrl = $favoriteBulbeUrl;
    }

    /**
     * @return \AppBundle\Entity\Media
     */
    public function getThumb1Image()
    {
        return $this->thumb1Image;
    }

    /**
     * @param \AppBundle\Entity\Media $thumb1Image
     */
    public function setThumb1Image($thumb1Image)
    {
        $this->thumb1Image = $thumb1Image;
    }

    /**
     * @return \AppBundle\Entity\Media
     */
    public function getThumb2Image()
    {
        return $this->thumb2Image;
    }

    /**
     * @param \AppBundle\Entity\Media $thumb2Image
     */
    public function setThumb2Image($thumb2Image)
    {
        $this->thumb2Image = $thumb2Image;
    }

    /**
     * @return \AppBundle\Entity\Media
     */
    public function getThumb3Image()
    {
        return $this->thumb3Image;
    }

    /**
     * @param \AppBundle\Entity\Media $thumb3Image
     */
    public function setThumb3Image($thumb3Image)
    {
        $this->thumb3Image = $thumb3Image;
    }

    /**
     * @return \AppBundle\Entity\Media
     */
    public function getThumb4Image()
    {
        return $this->thumb4Image;
    }

    /**
     * @param \AppBundle\Entity\Media $thumb4Image
     */
    public function setThumb4Image($thumb4Image)
    {
        $this->thumb4Image = $thumb4Image;
    }


}