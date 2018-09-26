<?php

namespace AppBundle\Entity\Filter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Project;

/**
 * ActivityFilter
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ActivityFilter extends AbstractFilter
{
    /**
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return ActivityFilter
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
