<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Filter\AbstractFilter;
use Caramia\AdminBundle\Admin\AbstractAdmin;
use Caramia\MediaBundle\Form\MediaType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FilterAdmin extends AbstractAdmin
{
    public function configure()
    {
        parent::configure();

        $em = $this->getConfigurationPool()->getContainer()->get('doctrine.orm.entity_manager');
        $metadata = $em->getMetadataFactory()->getMetadataFor(AbstractFilter::class);

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
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper){}

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nameAdmin')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $subject = $this->getSubject();

        switch (true) {
            case $subject instanceof \AppBundle\Entity\Filter\CustomerFilter:
                $formMapper
                    ->tab("Général")
                        ->with("Default")
                            ->add('logoCmjnImage', MediaType::class)
                            ->add('logoBlackImage', MediaType::class)
                        ->end()
                    ->end()
                    ;
                break;

            case $subject instanceof \AppBundle\Entity\Filter\AwardFilter:
                $formMapper
                    ->tab("Général")
                    ->with("Default")

                    ->end()
                    ->end()
                ;
                break;

            case $subject instanceof \AppBundle\Entity\Filter\TechFilter:
                $formMapper
                    ->tab("Général")
                    ->with("Default")
                        ->add("isInFooter")
                    ->end()
                    ->end()
                ;
                break;
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
