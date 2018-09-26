<?php

namespace AppBundle\Entity\Bulbe;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Caramia\TranslationBundle\Traits\TranslatableEntity;

/**
 * AbstractPage
 *
 * @ORM\Entity
 * @ORM\Table(name="bulbe")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\HasLifecycleCallbacks
 * @ORM\DiscriminatorMap({
 *     AbstractBulbe::TYPE_PROJECT="ProjectBulbe",
 *     AbstractBulbe::TYPE_FAVORITE="FavoriteBulbe",
 *     AbstractBulbe::TYPE_VIDEO="VideoBulbe",
 * })
 */
abstract class AbstractBulbe
{
    const TYPE_PROJECT  = 1;
    const TYPE_FAVORITE = 2;
    const TYPE_VIDEO    = 3;

    protected static $translationLabels = [
        ProjectBulbe::class  => "Projet Bulble",
        FavoriteBulbe::class => "Coup de coeur",
        VideoBulbe::class    => "Bulbe vidéo",
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
     * @var string
     *
     * @ORM\Column(name="blocSize", type="string")
     */
    protected $blocSize;

    private static $blocSizeList = [
        "Petit" => "small",
        "Moyen" => "medium",
        "Grand" => "big",
    ];


    public function __construct()
    {
        $this->registerTranslatableField('title', 'string');
    }

    public function __toString()
    {
        return $this->getTranslationLabel();
    }

    public function getTranslationLabel()
    {
        return self::$translationLabels[static::class];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTilteAdmin()
    {
        return $this->title->fr;
    }

    /**
     * @return int
     */
    public function getBlocSize()
    {
        return $this->blocSize;
    }

    /**
     * @param int $blocSize
     */
    public function setBlocSize($blocSize)
    {
        $this->blocSize = $blocSize;
    }

    /**
     * @return array
     */
    public static function getBlocSizeList()
    {
        return self::$blocSizeList;
    }
}