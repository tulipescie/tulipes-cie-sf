<?php

namespace AppBundle\Entity\Filter;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Caramia\TranslationBundle\Traits\TranslatableEntity;

/**
 * AbstractFilter
 *
 * @ORM\Entity
 * @ORM\Table(name="filter")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="integer")
 * @ORM\DiscriminatorMap({
 *     AbstractFilter::TYPE_ACTIVITY="ActivityFilter",
 *     AbstractFilter::TYPE_THEMATIC="ThematicFilter",
 *     AbstractFilter::TYPE_AWARD="AwardFilter",
 *     AbstractFilter::TYPE_TECH="TechFilter",
 *     AbstractFilter::TYPE_CUSTOMER="CustomerFilter",
 *     AbstractFilter::TYPE_DIRECTOR="DirectorFilter",
 * })
 */
abstract class AbstractFilter
{
    const TYPE_ACTIVITY = 1;
    const TYPE_THEMATIC = 2;
    const TYPE_AWARD    = 3;
    const TYPE_TECH     = 4;
    const TYPE_CUSTOMER = 5;
    const TYPE_DIRECTOR = 6;

    protected static $translationLabels = [
        ActivityFilter::class => "Secteur d'activité",
        ThematicFilter::class => "Thématique",
        AwardFilter::class    => "Récompense",
        TechFilter::class     => "Thechnologie",
        CustomerFilter::class => "Client",
        DirectorFilter::class => "Réalisateur",
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
        protected $name;

        /**
         * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Project", mappedBy="filters")
         */
        protected $projects;

    public function getTranslationLabel()
    {
        return self::$translationLabels[static::class];
    }

    public function __construct()
    {
        $this->registerTranslatableField('name', 'string');
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTranslationLabel();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getNameAdmin()
    {
        return $this->name->fr;
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
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return AbstractFilter
     */
    public function addProject(\AppBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \AppBundle\Entity\Project $project
     */
    public function removeProject(\AppBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }
}
