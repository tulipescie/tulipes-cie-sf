<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Page\AbstractPage;
use AppBundle\Entity\Page\AgencyPage;
use AppBundle\Entity\Page\BulbePage;
use AppBundle\Entity\Page\ContactPage;
use AppBundle\Entity\Page\HomePage;
use AppBundle\Entity\Page\LegalNoticePage;
use AppBundle\Entity\Page\NewsPage;
use AppBundle\Entity\Page\ProjectsPage;
use AppBundle\Entity\Page\TeamPage;
use Caramia\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Validator\Constraints as Assert;
use Caramia\MediaBundle\Annotation\MediaConstraints as MediaAssert;
use Caramia\MediaBundle\Form\MediaType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PageAdmin extends AbstractAdmin
{
    public function configure()
    {
        parent::configure();

        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
        $metadata = $em->getMetadataFactory()->getMetadataFor(AbstractPage::class);

        $map = [];
        foreach ($metadata->subClasses as $subclass) {
            $key = sprintf(
                'entity_%s',
                strtolower((new \ReflectionClass($subclass))->getShortName())
            );
            $map[$key] = $subclass;
        }

        $this->setSubClasses($map);

        $this->datagridValues['_sort_by']    = 'position';
        $this->datagridValues['_sort_order'] = 'ASC';

        $this->setTemplate('btn_instagram_access_token', 'AppBundle:Admin:token_acess_button.html.twig');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $subject = $this->getSubject();
        $actions = array('actions' => [
            'edit' => array(),
        ]);

//        if ($subject instanceof NewsPage) {
//            $actions['actions']['instagram'] = array(
//                'template' => 'AppBundle:Admin:token_acess_button.html.twig');
//        }

        $listMapper
            ->addIdentifier('titleAdmin')
            ->add('createdAt')
            ->add('_action', null, $actions)
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();

        $formMapper
            ->tab("Général")
                ->with("Default")
                    ->add('headerImage', MediaType::class)
                ->end()
        ;

        $formMapper->with("Specific");
        switch (true) {
            case $subject instanceof HomePage:
                $formMapper
                    ->add('headerImageMobile', MediaType::class)
                ->end()

                ->with("Video 1")
                    ->add('videoDesktopFile1', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 1 pour grand ércran',
                    ])
                    ->add('videoMobileFile1', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 1 pour petit écran',
                    ])
                ->end()

                ->with("Video 2")
                    ->add('videoDesktopFile2', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 2 pour grand ércran',
                    ])
                    ->add('videoMobileFile2', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 2 pour petit écran',
                    ])
                ->end()

                ->with("Video 3")
                    ->add('videoDesktopFile3', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 3 pour grand ércran',
                    ])
                    ->add('videoMobileFile3', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 3 pour petit écran',
                    ])
                ->end()

                ->with("Video 4")
                    ->add('videoDesktopFile4', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 4 pour grand ércran',
                    ])
                    ->add('videoMobileFile4', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 4 pour petit écran',
                    ])
                ->end()

                ->with("Video 5")
                    ->add('videoDesktopFile5', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 5 pour grand ércran',
                    ])
                    ->add('videoMobileFile5', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 5 pour petit écran',
                    ])
                ->end()

                ->with("Video 6")
                    ->add('videoDesktopFile6', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 6 pour grand ércran',
                    ])
                    ->add('videoMobileFile6', VichFileType::class, [
                        'required'       => false,
                        'download_label' => 'Voir la vidéo 6 pour petit écran',
                    ])
                ;
                break;

            case $subject instanceof AgencyPage:
                $formMapper
                    ->add('videoUrl', 'url')
                ;
                break;

            case $subject instanceof TeamPage:
                $formMapper
                    ->add('videoUrl', 'url')
                ;
                break;

            case $subject instanceof ProjectsPage:
                break;

            case $subject instanceof BulbePage:
                break;

            case $subject instanceof NewsPage:
                break;

            case $subject instanceof ContactPage:
                break;

            case $subject instanceof LegalNoticePage:
                break;
        }
        $formMapper->end();
        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('generate_instagram_access_token', 'generateInstagramAccessToken');
        $collection->add('generate_linkedin_access_token', 'generateLinkedinAccessToken');
    }

    public function configureActionButtons($action, $object = null)
    {
        $list = [];

        $list[]  = array(
            'template' => $this->getTemplate('btn_instagram_access_token'),
        );

        $list = array_merge($list, parent::configureActionButtons($action, $object));

        return $list;
    }

}
