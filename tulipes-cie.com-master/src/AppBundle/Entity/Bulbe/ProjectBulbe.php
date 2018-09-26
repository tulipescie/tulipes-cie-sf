<?php

namespace AppBundle\Entity\Bulbe;

use Doctrine\ORM\Mapping as ORM;

/**
 * VideoBulbe
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ProjectBulbe extends AbstractBulbe
{
    /**
     * @var \AppBundle\Entity\Project
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bulbe_project_id", referencedColumnName="id", nullable=true)
     * })
     */
    protected $bulbeProject;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_disp_in_project", type="boolean", options={"default":true})
     */
    protected $isDispInProject;

    /**
     * @return \AppBundle\Entity\Project
     */
    public function getBulbeProject()
    {
        return $this->bulbeProject;
    }

    /**
     * @param \AppBundle\Entity\Project $bulbeProject
     */
    public function setBulbeProject($bulbeProject)
    {
        $this->bulbeProject = $bulbeProject;
    }

    /**
     * @return bool
     */
    public function isDispInProject()
    {
        return $this->isDispInProject;
    }

    /**
     * @param bool $isDispInProject
     */
    public function setIsDispInProject($isDispInProject)
    {
        $this->isDispInProject = $isDispInProject;
    }

    public function getTitleProject() {
        return $this->bulbeProject->getTitle();
    }

}