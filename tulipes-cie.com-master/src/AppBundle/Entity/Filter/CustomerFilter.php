<?php

namespace AppBundle\Entity\Filter;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Project;

use Caramia\MediaBundle\Annotation\MediaConstraints as MediaAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CustomerFilter
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class CustomerFilter extends AbstractFilter
{
    /**
     * @var \Caramia\MediaBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logo_cmjn_image", referencedColumnName="id", nullable=true)
     * })
     * @Assert\NotBlank(),
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $logoCmjnImage;

    /**
     * @var \Caramia\MediaBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logo_black_image", referencedColumnName="id", nullable=true)
     * })
     * @Assert\NotBlank(),
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $logoBlackImage;

    /**
     * Set logoCmjnImage
     *
     * @param string $logoCmjnImage
     *
     * @return CustomerFilter
     */
    public function setLogoCmjnImage($logoCmjnImage)
    {
        $this->logoCmjnImage = $logoCmjnImage;

        return $this;
    }

    /**
     * Get logoCmjnImage
     *
     * @return string
     */
    public function getLogoCmjnImage()
    {
        return $this->logoCmjnImage;
    }

    /**
     * Set logoBlackImage
     *
     * @param string $logoBlackImage
     *
     * @return CustomerFilter
     */
    public function setLogoBlackImage($logoBlackImage)
    {
        $this->logoBlackImage = $logoBlackImage;

        return $this;
    }

    /**
     * Get logoBlackImage
     *
     * @return string
     */
    public function getLogoBlackImage()
    {
        return $this->logoBlackImage;
    }

    /**
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return CustomerFilter
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
