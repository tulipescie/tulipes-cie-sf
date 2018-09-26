<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Filter\ActivityFilter;
use AppBundle\Entity\Filter\AwardFilter;
use AppBundle\Entity\Filter\CustomerFilter;
use AppBundle\Entity\Filter\DirectorFilter;
use AppBundle\Entity\Filter\InteractifFilter;
use AppBundle\Entity\Filter\TechFilter;
use AppBundle\Entity\Filter\ThematicFilter;
use AppBundle\Entity\Filter\YearFilter;
use AppBundle\Exception\FilterNotExistException;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Caramia\TranslationBundle\Traits\TranslatableEntity;

use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\Validator\Constraints as Assert;
use Caramia\MediaBundle\Annotation\MediaConstraints as MediaAssert;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Project
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;
    use TranslatableEntity;

    public static $filtersTypes = [
        'Activity' => ActivityFilter::class,
        'Thematic' => ThematicFilter::class,
        'Award' => AwardFilter::class,
        'Tech' => TechFilter::class,
        'Customer' => CustomerFilter::class,
        'Director' => DirectorFilter::class,
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="json_array")
     */
    protected $title;

    /**
     * @var \AppBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="header_image", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotBlank(),
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $headerImage;

    /**
     * @var \AppBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="thumb1_image", referencedColumnName="id", nullable=false)
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
     *   @ORM\JoinColumn(name="thumb2_image", referencedColumnName="id", nullable=true)
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
     *   @ORM\JoinColumn(name="thumb3_image", referencedColumnName="id", nullable=true)
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
     *   @ORM\JoinColumn(name="thumb4_image", referencedColumnName="id", nullable=true)
     * })
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $thumb4Image;

    /**
     * @var \AppBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="thumb5_image", referencedColumnName="id", nullable=true)
     * })
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $thumb5Image;

    /**
     * @var string
     *
     * @ORM\Column(name="video_url", type="json_array", nullable=false)
     */
    protected $videoUrl;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\CkeditorTranslatable")
     */
    protected $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_not_show", type="boolean")
     */
    protected $isNotShow;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $onlineAt;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Filter\AbstractFilter", inversedBy="projects")
     * @ORM\JoinTable(name="projects_filters")
     */
    protected $filters;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", unique=true, nullable=false)
     */
    protected $slug;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registerTranslatableField('content', 'ckeditor');
        $this->filters = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return (String) $this->title;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return [type] [description]
     */
    public function updateMediaTitle()
    {
        return;
        $this->headerImage->setTitle(sprintf(
            '%s_headerImage_%s',
            (new \ReflectionClass(static::class))->getShortName(),
            \Behat\Transliterator\Transliterator::transliterate($this->title)
        ));

        $this->thumb1Image->setTitle(sprintf(
            '%s_thumb1Image_%s',
            (new \ReflectionClass(static::class))->getShortName(),
            \Behat\Transliterator\Transliterator::transliterate($this->title)
        ));

        $this->thumb2Image->setTitle(sprintf(
            '%s_thumb2Image_%s',
            (new \ReflectionClass(static::class))->getShortName(),
            \Behat\Transliterator\Transliterator::transliterate($this->title)
        ));

        $this->thumb3Image->setTitle(sprintf(
            '%s_thumb3Image_%s',
            (new \ReflectionClass(static::class))->getShortName(),
            \Behat\Transliterator\Transliterator::transliterate($this->title)
        ));

        $this->thumb4Image->setTitle(sprintf(
            '%s_thumb4Image_%s',
            (new \ReflectionClass(static::class))->getShortName(),
            \Behat\Transliterator\Transliterator::transliterate($this->title)
        ));

        $this->thumb5Image->setTitle(sprintf(
            '%s_thumb5Image_%s',
            (new \ReflectionClass(static::class))->getShortName(),
            \Behat\Transliterator\Transliterator::transliterate($this->title)
        ));
    }

    public function getFiltersWithClass($class)
    {
        return $this->filters->filter(function ($filter) use ($class) {
            return $filter instanceof $class;
        });

    }

    public function getFiltersWithLabel($label)
    {
        if (!array_key_exists($label, self::$filtersTypes)) {
            throw new FilterNotExistException;
        }
        $class = self::$filtersTypes[$label];
        return $this->getFiltersWithClass($class);

    }

    public function setFiltersWithClass($class, $filters)
    {
        foreach ($this->getFiltersWithClass($class) as $filter){
            $this->removeFilter($filter);
        }
        foreach ($filters as $filter){
            $this->addFilter($filter);
        }
        return $this;

    }

    public function __get($name)
    {
        $guessedFilterType = $this->guessFilterType($name);
        if (null !== $guessedFilterType) {
            return $this->getFiltersWithClass($guessedFilterType);
        }
    }

     public function __set($name, $value)
    {
        $guessedFilterType = $this->guessFilterType($name);
        if (null !== $guessedFilterType) {
            return $this->setFiltersWithClass($guessedFilterType, $value);
        }
    }

    protected function guessFilterType($name)
    {
        $matches = [];
        $regexp = sprintf(
            '#(?:[gs]et)?[Ff]ilters(?<type>(?:%s))#',
            implode('|', array_keys(self::$filtersTypes))
        );
        preg_match_all(
            $regexp,
            $name,
            $matches
        );

        return empty($matches['type']) ? null : self::$filtersTypes[current($matches['type'])];
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param array $title
     *
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return array
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set headerImage
     *
     * @param string $headerImage
     *
     * @return Project
     */
    public function setHeaderImage($headerImage)
    {
        $this->headerImage = $headerImage;

        return $this;
    }

    /**
     * Get headerImage
     *
     * @return string
     */
    public function getHeaderImage()
    {
        return $this->headerImage;
    }

    /**
     * Set thumb1Image
     *
     * @param string $thumb1Image
     *
     * @return Project
     */
    public function setThumb1Image($thumb1Image)
    {
        $this->thumb1Image = $thumb1Image;

        return $this;
    }

    /**
     * Get thumb1Image
     *
     * @return string
     */
    public function getThumb1Image()
    {
        return $this->thumb1Image;
    }

    /**
     * Set thumb2Image
     *
     * @param string $thumb2Image
     *
     * @return Project
     */
    public function setThumb2Image($thumb2Image)
    {
        $this->thumb2Image = $thumb2Image;

        return $this;
    }

    /**
     * Get thumb2Image
     *
     * @return string
     */
    public function getThumb2Image()
    {
        return $this->thumb2Image;
    }

    /**
     * Set thumb3Image
     *
     * @param string $thumb3Image
     *
     * @return Project
     */
    public function setThumb3Image($thumb3Image)
    {
        $this->thumb3Image = $thumb3Image;

        return $this;
    }

    /**
     * Get thumb3Image
     *
     * @return string
     */
    public function getThumb3Image()
    {
        return $this->thumb3Image;
    }

    /**
     * Set thumb4Image
     *
     * @param string $thumb4Image
     *
     * @return Project
     */
    public function setThumb4Image($thumb4Image)
    {
        $this->thumb4Image = $thumb4Image;

        return $this;
    }

    /**
     * Get thumb4Image
     *
     * @return string
     */
    public function getThumb4Image()
    {
        return $this->thumb4Image;
    }

    /**
     * Set thumb5Image
     *
     * @param string $thumb5Image
     *
     * @return Project
     */
    public function setThumb5Image($thumb5Image)
    {
        $this->thumb5Image = $thumb5Image;

        return $this;
    }

    /**
     * Get thumb5Image
     *
     * @return string
     */
    public function getThumb5Image()
    {
        return $this->thumb5Image;
    }

    /**
     * Set videoUrl
     *
     * @param array $videoUrl
     *
     * @return Project
     */
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    /**
     * Get videoUrl
     *
     * @return array
     */
    public function getVideoUrl()
    {
        return $this->videoUrl;
    }

    /**
     * Set content
     *
     * @param array $content
     *
     * @return Project
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return array
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set isNotShow
     *
     * @param boolean $isNotShow
     *
     * @return Project
     */
    public function setIsNotShow($isNotShow)
    {
        $this->isNotShow = $isNotShow;

        return $this;
    }

    /**
     * Get isNotShow
     *
     * @return boolean
     */
    public function getIsNotShow()
    {
        return $this->isNotShow;
    }

    /**
     * Set onlineAt
     *
     * @param \DateTime $onlineAt
     *
     * @return Project
     */
    public function setOnlineAt($onlineAt)
    {
        $this->onlineAt = $onlineAt;

        return $this;
    }

    /**
     * Get onlineAt
     *
     * @return \DateTime
     */
    public function getOnlineAt()
    {
        return $this->onlineAt;
    }

    /**
     * Add filter
     *
     * @param \AppBundle\Entity\Filter\AbstractFilter $filter
     *
     * @return Project
     */
    public function addFilter(\AppBundle\Entity\Filter\AbstractFilter $filter)
    {
        $this->filters[] = $filter;

        return $this;
    }

    /**
     * Remove filter
     *
     * @param \AppBundle\Entity\Filter\AbstractFilter $filter
     */
    public function removeFilter(\AppBundle\Entity\Filter\AbstractFilter $filter)
    {
        $this->filters->removeElement($filter);
    }

    /**
     * Get filters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        if (empty($this->slug)) {
            $this->slug = $slug;
        }

    }

}
