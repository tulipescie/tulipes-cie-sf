<?php

namespace AppBundle\Admin;

use Caramia\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ContactAdmin extends AbstractAdmin
{
    public function configure()
    {
        parent::configure();

        $this->datagridValues['_sort_by']    = 'createdAt';
        $this->datagridValues['_sort_order'] = 'DESC';
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('get_file', $this->getRouterIdParameter().'/file');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('company')
            ->add('name')
            ->add('email')
            ->add('telephone')
            ->add('object')
            ->add('createdAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('company')
            ->add('name')
            ->add('email')
            ->add('telephone')
            ->add('object')
            ->add('createdAt')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
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
        $formMapper
            ->add('company')
            ->add('name')
            ->add('email')
            ->add('telephone')
            ->add('object')
            ->add('message')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('company')
            ->add('name')
            ->add('email')
            ->add('telephone')
            ->add('object')
            ->add('message')
            ->add('fileOriginalName', null, [
                'safe' => true,
                'template' => 'AppBundle:Admin:contact_get_file.html.twig',
            ])
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
