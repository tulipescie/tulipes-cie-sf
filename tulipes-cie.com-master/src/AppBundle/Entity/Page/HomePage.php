<?php

namespace AppBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Caramia\MediaBundle\Annotation\MediaConstraints as MediaAssert;

/**
 * HomePage
 *
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class HomePage extends AbstractPage
{

    /**
     * @var \AppBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Media", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="header_image_mobile", referencedColumnName="id", nullable=true)
     * })
     * @Assert\NotBlank(),
     * @MediaAssert({
     *   @Assert\Image(),
     * })
     */
    protected $headerImageMobile;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoDesktop1")
     */
    private $videoDesktopFile1;

    /**
     * @var String
     * @ORM\Column(name="video_desktop_1", type="string", length=511, nullable=true)
     */
    private $videoDesktop1;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoDesktop2")
     */
    private $videoDesktopFile2;

    /**
     * @var String
     * @ORM\Column(name="video_desktop_2", type="string", length=511, nullable=true)
     */
    private $videoDesktop2;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoDesktop3")
     */
    private $videoDesktopFile3;

    /**
     * @var String
     * @ORM\Column(name="video_desktop_3", type="string", length=511, nullable=true)
     */
    private $videoDesktop3;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoDesktop4")
     */
    private $videoDesktopFile4;

    /**
     * @var String
     * @ORM\Column(name="video_desktop_4", type="string", length=511, nullable=true)
     */
    private $videoDesktop4;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoDesktop5")
     */
    private $videoDesktopFile5;

    /**
     * @var String
     * @ORM\Column(name="video_desktop_5", type="string", length=511, nullable=true)
     */
    private $videoDesktop5;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoDesktop6")
     */
    private $videoDesktopFile6;

    /**
     * @var String
     * @ORM\Column(name="video_desktop_6", type="string", length=511, nullable=true)
     */
    private $videoDesktop6;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoMobile1")
     */
    private $videoMobileFile1;

    /**
     * @var String
     * @ORM\Column(name="video_mobile_1", type="string", length=511, nullable=true)
     */
    private $videoMobile1;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoMobile2")
     */
    private $videoMobileFile2;

    /**
     * @var String
     * @ORM\Column(name="video_mobile_2", type="string", length=511, nullable=true)
     */
    private $videoMobile2;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoMobile3")
     */
    private $videoMobileFile3;

    /**
     * @var String
     * @ORM\Column(name="video_mobile_3", type="string", length=511, nullable=true)
     */
    private $videoMobile3;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoMobile4")
     */
    private $videoMobileFile4;

    /**
     * @var String
     * @ORM\Column(name="video_mobile_4", type="string", length=511, nullable=true)
     */
    private $videoMobile4;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoMobile5")
     */
    private $videoMobileFile5;

    /**
     * @var String
     * @ORM\Column(name="video_mobile_5", type="string", length=511, nullable=true)
     */
    private $videoMobile5;

    /**
     * @Assert\File(
     *     maxSize="100M",
     *     mimeTypes = {"video/mp4", "video/x-m4v"},
     *     mimeTypesMessage = "Mauvais type de fichier. Veuillez uploader que des fichiers au format MP4."
     * )
     * @var File
     * @Vich\UploadableField(mapping="media_item", fileNameProperty="videoMobile6")
     */
    private $videoMobileFile6;

    /**
     * @var String
     * @ORM\Column(name="video_mobile_6", type="string", length=511, nullable=true)
     */
    private $videoMobile6;



    // Auto doctrine

    /**
     * Set headerImageMobile
     *
     * @param string $headerImageMobile
     *
     * @return AbstractPage
     */
    public function setHeaderImageMobile($headerImageMobile)
    {
        $this->headerImageMobile = $headerImageMobile;

        return $this;
    }

    /**
     * Get headerImageMobile
     *
     * @return string
     */
    public function getHeaderImageMobile()
    {
        return $this->headerImageMobile;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoDesktop1
     *
     * @return HomePage
     */
    public function setVideoDesktopFile1(File $videoDesktop1 = null)
    {
        $this->videoDesktopFile1 = $videoDesktop1;

        if ($videoDesktop1) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoDesktopFile1
     *
     * @return File|null
     */
    public function getVideoDesktopFile1()
    {
        return $this->videoDesktopFile1;
    }

    /**
     * Set videoDesktop1
     *
     * @param string $videoDesktop1
     * @return HomePage
     */
    public function setVideoDesktop1($videoDesktop1)
    {
        $this->videoDesktop1 = $videoDesktop1;

        return $this;
    }

    /**
     * Get videoDesktop1
     *
     * @return string
     */
    public function getVideoDesktop1()
    {
        return $this->videoDesktop1;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoDesktop2
     *
     * @return HomePage
     */
    public function setVideoDesktopFile2(File $videoDesktop2 = null)
    {
        $this->videoDesktopFile2 = $videoDesktop2;

        if ($videoDesktop2) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoDesktopFile2
     *
     * @return File|null
     */
    public function getVideoDesktopFile2()
    {
        return $this->videoDesktopFile2;
    }

    /**
     * Set videoDesktop2
     *
     * @param string $videoDesktop2
     * @return HomePage
     */
    public function setVideoDesktop2($videoDesktop2)
    {
        $this->videoDesktop2 = $videoDesktop2;

        return $this;
    }

    /**
     * Get videoDesktop2
     *
     * @return string
     */
    public function getVideoDesktop2()
    {
        return $this->videoDesktop2;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoDesktop3
     *
     * @return HomePage
     */
    public function setVideoDesktopFile3(File $videoDesktop3 = null)
    {
        $this->videoDesktopFile3 = $videoDesktop3;

        if ($videoDesktop3) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoDesktopFile3
     *
     * @return File|null
     */
    public function getVideoDesktopFile3()
    {
        return $this->videoDesktopFile3;
    }

    /**
     * Set videoDesktop3
     *
     * @param string $videoDesktop3
     * @return HomePage
     */
    public function setVideoDesktop3($videoDesktop3)
    {
        $this->videoDesktop3 = $videoDesktop3;

        return $this;
    }

    /**
     * Get videoDesktop3
     *
     * @return string
     */
    public function getVideoDesktop3()
    {
        return $this->videoDesktop3;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoDesktop4
     *
     * @return HomePage
     */
    public function setVideoDesktopFile4(File $videoDesktop4 = null)
    {
        $this->videoDesktopFile4 = $videoDesktop4;

        if ($videoDesktop4) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoDesktopFile4
     *
     * @return File|null
     */
    public function getVideoDesktopFile4()
    {
        return $this->videoDesktopFile4;
    }

    /**
     * Set videoDesktop4
     *
     * @param string $videoDesktop4
     * @return HomePage
     */
    public function setVideoDesktop4($videoDesktop4)
    {
        $this->videoDesktop4 = $videoDesktop4;

        return $this;
    }

    /**
     * Get videoDesktop4
     *
     * @return string
     */
    public function getVideoDesktop4()
    {
        return $this->videoDesktop4;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoDesktop5
     *
     * @return HomePage
     */
    public function setVideoDesktopFile5(File $videoDesktop5 = null)
    {
        $this->videoDesktopFile5 = $videoDesktop5;

        if ($videoDesktop5) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoDesktopFile5
     *
     * @return File|null
     */
    public function getVideoDesktopFile5()
    {
        return $this->videoDesktopFile5;
    }

    /**
     * Set videoDesktop5
     *
     * @param string $videoDesktop5
     * @return HomePage
     */
    public function setVideoDesktop5($videoDesktop5)
    {
        $this->videoDesktop5 = $videoDesktop5;

        return $this;
    }

    /**
     * Get videoDesktop5
     *
     * @return string
     */
    public function getVideoDesktop5()
    {
        return $this->videoDesktop5;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoDesktop6
     *
     * @return HomePage
     */
    public function setVideoDesktopFile6(File $videoDesktop6 = null)
    {
        $this->videoDesktopFile6 = $videoDesktop6;

        if ($videoDesktop6) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoDesktopFile6
     *
     * @return File|null
     */
    public function getVideoDesktopFile6()
    {
        return $this->videoDesktopFile6;
    }

    /**
     * Set videoDesktop6
     *
     * @param string $videoDesktop6
     * @return HomePage
     */
    public function setVideoDesktop6($videoDesktop6)
    {
        $this->videoDesktop6 = $videoDesktop6;

        return $this;
    }

    /**
     * Get videoDesktop6
     *
     * @return string
     */
    public function getVideoDesktop6()
    {
        return $this->videoDesktop6;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoMobileFile1
     *
     * @return HomePage
     */
    public function setVideoMobileFile1(File $videoMobileFile1 = null)
    {
        $this->videoMobileFile1 = $videoMobileFile1;

        if ($videoMobileFile1) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoMobileFile1
     *
     * @return File|null
     */
    public function getVideoMobileFile1()
    {
        return $this->videoMobileFile1;
    }

    /**
     * Set videoMobile1
     *
     * @param string $videoMobile1
     * @return HomePage
     */
    public function setVideoMobile1($videoMobile1)
    {
        $this->videoMobile1 = $videoMobile1;

        return $this;
    }

    /**
     * Get videoMobile1
     *
     * @return string
     */
    public function getVideoMobile1()
    {
        return $this->videoMobile1;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoMobileFile2
     *
     * @return HomePage
     */
    public function setVideoMobileFile2(File $videoMobileFile2 = null)
    {
        $this->videoMobileFile2 = $videoMobileFile2;

        if ($videoMobileFile2) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoMobileFile2
     *
     * @return File|null
     */
    public function getVideoMobileFile2()
    {
        return $this->videoMobileFile2;
    }

    /**
     * Set videoMobile2
     *
     * @param string $videoMobile2
     * @return HomePage
     */
    public function setVideoMobile2($videoMobile2)
    {
        $this->videoMobile2 = $videoMobile2;

        return $this;
    }

    /**
     * Get videoMobile2
     *
     * @return string
     */
    public function getVideoMobile2()
    {
        return $this->videoMobile2;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoMobileFile3
     *
     * @return HomePage
     */
    public function setVideoMobileFile3(File $videoMobileFile3 = null)
    {
        $this->videoMobileFile3 = $videoMobileFile3;

        if ($videoMobileFile3) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoMobileFile3
     *
     * @return File|null
     */
    public function getVideoMobileFile3()
    {
        return $this->videoMobileFile3;
    }

    /**
     * Set videoMobile3
     *
     * @param string $videoMobile3
     * @return HomePage
     */
    public function setVideoMobile3($videoMobile3)
    {
        $this->videoMobile3 = $videoMobile3;

        return $this;
    }

    /**
     * Get videoMobile3
     *
     * @return string
     */
    public function getVideoMobile3()
    {
        return $this->videoMobile3;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoMobileFile4
     *
     * @return HomePage
     */
    public function setVideoMobileFile4(File $videoMobileFile4 = null)
    {
        $this->videoMobileFile4 = $videoMobileFile4;

        if ($videoMobileFile4) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoMobileFile4
     *
     * @return File|null
     */
    public function getVideoMobileFile4()
    {
        return $this->videoMobileFile4;
    }

    /**
     * Set videoMobile4
     *
     * @param string $videoMobile4
     * @return HomePage
     */
    public function setVideoMobile4($videoMobile4)
    {
        $this->videoMobile4 = $videoMobile4;

        return $this;
    }

    /**
     * Get videoMobile4
     *
     * @return string
     */
    public function getVideoMobile4()
    {
        return $this->videoMobile4;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoMobileFile5
     *
     * @return HomePage
     */
    public function setVideoMobileFile5(File $videoMobileFile5 = null)
    {
        $this->videoMobileFile5 = $videoMobileFile5;

        if ($videoMobileFile5) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoMobileFile5
     *
     * @return File|null
     */
    public function getVideoMobileFile5()
    {
        return $this->videoMobileFile5;
    }

    /**
     * Set videoMobile5
     *
     * @param string $videoMobile5
     * @return HomePage
     */
    public function setVideoMobile5($videoMobile5)
    {
        $this->videoMobile5 = $videoMobile5;

        return $this;
    }

    /**
     * Get videoMobile5
     *
     * @return string
     */
    public function getVideoMobile5()
    {
        return $this->videoMobile5;
    }

    /**
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $videoMobileFile6
     *
     * @return HomePage
     */
    public function setVideoMobileFile6(File $videoMobileFile6 = null)
    {
        $this->videoMobileFile6 = $videoMobileFile6;

        if ($videoMobileFile6) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * Get videoMobileFile6
     *
     * @return File|null
     */
    public function getVideoMobileFile6()
    {
        return $this->videoMobileFile6;
    }

    /**
     * Set videoMobile6
     *
     * @param string $videoMobile6
     * @return HomePage
     */
    public function setVideoMobile6($videoMobile6)
    {
        $this->videoMobile6 = $videoMobile6;

        return $this;
    }

    /**
     * Get videoMobile6
     *
     * @return string
     */
    public function getVideoMobile6()
    {
        return $this->videoMobile6;
    }
}
