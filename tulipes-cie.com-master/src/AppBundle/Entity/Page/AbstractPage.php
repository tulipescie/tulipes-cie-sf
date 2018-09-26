<?php

namespace AppBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Caramia\TranslationBundle\Traits\TranslatableEntity;

use Symfony\Component\Validator\Constraints as Assert;
use Caramia\MediaBundle\Annotation\MediaConstraints as MediaAssert;

/**
 * AbstractPage
 *
 * @ORM\Entity
 * @ORM\Table(name="page")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\HasLifecycleCallbacks
 * @ORM\DiscriminatorMap({
 *     AbstractPage::TYPE_HOME="HomePage",
 *     AbstractPage::TYPE_AGENCY="AgencyPage",
 *     AbstractPage::TYPE_TEAM="TeamPage",
 *     AbstractPage::TYPE_PROJECTS="ProjectsPage",
 *     AbstractPage::TYPE_BULBE="BulbePage",
 *     AbstractPage::TYPE_NEWS="NewsPage",
 *     AbstractPage::TYPE_CONTACT="ContactPage",
 *     AbstractPage::TYPE_LEGAL_NOTICE="LegalNoticePage",
 * })
 */
abstract class AbstractPage
{
    const TYPE_HOME         = 1;
    const TYPE_AGENCY       = 2;
    const TYPE_TEAM         = 3;
    const TYPE_PROJECTS     = 4;
    const TYPE_BULBE        = 5;
    const TYPE_NEWS         = 6;
    const TYPE_CONTACT      = 7;
    const TYPE_LEGAL_NOTICE = 8;

    protected static $translationLabels = [
        HomePage::class        => "Page d'accueil",
        AgencyPage::class      => "Page de l'agence",
        TeamPage::class        => "Page de l'équipe",
        ProjectsPage::class    => "Page des réalisation",
        BulbePage::class       => "Page de bulbe",
        ContactPage::class     => "Page de contact",
        NewsPage::class        => "Page des actualités",
        LegalNoticePage::class => "Page des mentions légales",
    ];


    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    use TranslatableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
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
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $metaTitle;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $metaDesc;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $metaTag;

    public function getTranslationLabel()
    {
        return self::$translationLabels[static::class];
    }

    public function __construct()
    {
        $this->registerTranslatableField('title', 'string');
        $this->registerTranslatableField('metaTitle', 'string');
        $this->registerTranslatableField('metaDesc', 'string');
        $this->registerTranslatableField('metaTag', 'string');
    }

    public function __toString()
    {
        return $this->getTranslationLabel();
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function getTitleAdmin()
    {
        return $this->title->fr;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set headerImage
     *
     * @param string $headerImage
     *
     * @return AbstractPage
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
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * @param string $metaTitle
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * Set metaDesc
     *
     * @param array $metaDesc
     *
     * @return AbstractPage
     */
    public function setMetaDesc($metaDesc)
    {
        $this->metaDesc = $metaDesc;

        return $this;
    }

    /**
     * Get metaDesc
     *
     * @return array
     */
    public function getMetaDesc()
    {
        return $this->metaDesc;
    }

    /**
     * Set metaTag
     *
     * @param array $metaTag
     *
     * @return AbstractPage
     */
    public function setMetaTag($metaTag)
    {
        $this->metaTag = $metaTag;

        return $this;
    }

    /**
     * Get metaTag
     *
     * @return array
     */
    public function getMetaTag()
    {
        return $this->metaTag;
    }
}
