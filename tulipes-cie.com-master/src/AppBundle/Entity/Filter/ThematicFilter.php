<?php

namespace AppBundle\Entity\Filter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Project;

/**
 * ThematicFilter
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ThematicFilter extends AbstractFilter
{
    /**
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return ThematicFilter
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
