<?php

namespace AppBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;

/**
 * BulbePage
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class BulbePage extends AbstractPage
{

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\StringTranslatable")
     */
    protected $explainTitle;

    /**
     * @var string
     *
     * @ORM\Embedded(class="Caramia\TranslationBundle\Entity\CkeditorTranslatable")
     */
    protected $explainDesc;


    public function __construct()
    {
        parent::__construct();

        $this->registerTranslatableField('explainTitle', 'string');
        $this->registerTranslatableField('explainDesc', 'ckeditor');

    }

    /**
     * @return string
     */
    public function getExplainTitle()
    {
        return $this->explainTitle;
    }

    /**
     * @param string $explainTitle
     */
    public function setExplainTitle($explainTitle)
    {
        $this->explainTitle = $explainTitle;
    }

    /**
     * @return string
     */
    public function getExplainDesc()
    {
        return $this->explainDesc;
    }

    /**
     * @param string $explainDesc
     */
    public function setExplainDesc($explainDesc)
    {
        $this->explainDesc = $explainDesc;
    }

}