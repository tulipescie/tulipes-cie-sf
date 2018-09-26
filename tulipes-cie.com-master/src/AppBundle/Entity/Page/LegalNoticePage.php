<?php

namespace AppBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;

/**
 * LegalNoticePage
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class LegalNoticePage extends AbstractPage
{
    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\CkeditorTranslatable")
     */
    protected $content;

    public function __construct()
    {
        parent::__construct();

        $this->registerTranslatableField('content', 'ckeditor');
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
}
