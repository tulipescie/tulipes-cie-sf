<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Caramia\MediaBundle\Entity\Media as BaseMedia;
use Caramia\TranslationBundle\Traits\TranslatableEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Media
 * 
 * @ORM\Entity
 * @ORM\Table(name="media__tulipe")
 */
class Media extends BaseMedia
{
    use TranslatableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $description;

    public function __construct()
    {
        $this->registerTranslatableField('description', 'string');

        parent::__construct();
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


}

