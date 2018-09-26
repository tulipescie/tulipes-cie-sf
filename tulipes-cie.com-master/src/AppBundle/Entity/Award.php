<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Caramia\TranslationBundle\Traits\TranslatableEntity;

/**
 * Award
 *
 * @ORM\Table(name="award")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Award
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


    public function __construct()
    {
        $this->registerTranslatableField('title', 'string');
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
     * @return Award
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
}

