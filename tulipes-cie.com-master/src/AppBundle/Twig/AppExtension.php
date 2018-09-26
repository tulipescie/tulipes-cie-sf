<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Filter\TechFilter;
use AppBundle\Entity\NewsletterSubscriber;
use AppBundle\Entity\Page\HomePage;
use AppBundle\Entity\Project;
use AppBundle\Form\NewsletterSubscriberType;
use Caramia\TranslationBundle\Service\TranslatableManager;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class AppExtension extends \Twig_Extension
{
    private $em;

    use ContainerAwareTrait;

    public function getName()
    {
        return 'app_extension';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('translateAttribute', [$this, 'translateAttribute']),
            new \Twig_SimpleFunction('issetMediaImage', [$this, 'issetMediaImage']),
            new \Twig_SimpleFunction('getSiteDescription', [$this, 'getSiteDescription']),
            new \Twig_SimpleFunction('getFistFiveProjects', [$this, 'getFistFiveProjects']),
            new \Twig_SimpleFunction('getFavoriteTech', [$this, 'getFavoriteTech']),
            new \Twig_SimpleFunction('newletterForm', [$this, 'newletterForm']),
            new \Twig_SimpleFunction('isInstanceof', [$this, 'isInstanceof']),
        ];
    }

    /**
     * Construct doctrine entity manager
     *
     * @return EntityManager
     */
    private function getEm()
    {
        if (!$this->em) {
            $this->em = $this->container->get('doctrine.orm.entity_manager');
        }

        return $this->em;
    }

    /**
     * @param $attribute
     * @param $lang
     *
     * @return the attribute's translation by the Locale $lang if it exists else the Locale Default
     */
    public function translateAttribute($attribute, $lang)
    {
        if (!in_array($lang, TranslatableManager::getLangs())) {
            $lang = \Locale::getDefault();
        }

        return $attribute->$lang;
    }

    /**
     * @param $image
     *
     * @return asset media by vich uploader
     */
    public function issetMediaImage($image) {
        if ($image == null) {
            return null;
        }

        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');

        return $helper->asset($image, 'imageFile');
    }


    /**
     * @return la méta description de la classe Homepage
     */
    public function getSiteDescription($locale)
    {
        $desc = $this->getEm()->getRepository(HomePage::class)
            ->createQueryBuilder('h')
            ->select('h.metaDesc.' . $locale)
            ->orderBy("h.createdAt", "DESC")
            ->getQuery()->getResult()[0];

        return $desc['metaDesc.' . $locale];
    }


    /**
     * @return the first five projects
     */
    public function getFistFiveProjects()
    {
        $projects = $this->getEm()->getRepository(Project::class)->findProjectsByLimit(0, 4);

        return $projects;
    }

    /**
     * @return all techonologies
     */
    public function getFavoriteTech()
    {
        $technos = $this->getEm()->getRepository(TechFilter::class)
            ->findBy(['isInFooter' => true ], ['createdAt' => 'desc']);;

        return $technos;
    }

    /**
     * @return NewsletterSubscriber form
     */
    public function newletterForm()
    {
        $newletterSubscriber = new NewsletterSubscriber();
        $form = $this->container->get('form.factory')->create(NewsletterSubscriberType::class, $newletterSubscriber);

        return $form->createView();
    }

    /**
     * @param $obj
     * @param $instance
     * @return true if Object $obj is instance of instance
     */
    public function isInstanceof($obj, $instance)
    {
        $name = (new \ReflectionClass($obj))->getShortName();
        return $name == $instance;
    }
}