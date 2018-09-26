<?php

namespace AppBundle\Entity\Filter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Project;

/**
 * TechFilter
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class TechFilter extends AbstractFilter
{

    /**
     * @var bool
     *
     * @ORM\Column(name="is_in_footer", type="boolean", nullable=true)
     */
    protected $isInFooter;

    /**
     * @return bool
     */
    public function isInFooter()
    {
        return $this->isInFooter;
    }

    /**
     * @param bool $isInFooter
     */
    public function setIsInFooter($isInFooter)
    {
        $this->isInFooter = $isInFooter;
    }



    /**
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return TechFilter
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
