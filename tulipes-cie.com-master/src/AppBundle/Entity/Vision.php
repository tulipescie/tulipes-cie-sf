<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Caramia\TranslationBundle\Traits\TranslatableEntity;

/**
 * Vision
 *
 * @ORM\Table(name="vision")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Vision
{
    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;
    use TranslatableEntity;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\CkeditorTranslatable")
     */
    private $description;



    public function __construct()
    {
        $this->registerTranslatableField('title', 'string');
        $this->registerTranslatableField('description', 'ckeditor');

    }

    public function __toString()
    {
        return (String) $this->title->fr;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Vision
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
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
     * Set description
     *
     * @param string $description
     *
     * @return Vision
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

