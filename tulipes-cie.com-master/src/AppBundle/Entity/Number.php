<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Caramia\TranslationBundle\Traits\TranslatableEntity;

/**
 * Number
 *
 * @ORM\Table(name="number")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Number
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
     * @ORM\Column(name="total", type="integer", length=10)
     */
    private $total;



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
     * @return Number
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
     * Set total
     *
     * @param integer $total
     *
     * @return Number
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }
}

