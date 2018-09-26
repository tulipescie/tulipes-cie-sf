<?php

namespace AppBundle\Admin;

use Caramia\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\Type as SonataForm;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class FigureAdmin extends AbstractAdmin
{

    public function configure()
    {
        parent::configure();

        $this->datagridValues['_sort_by']    = 'position';
        $this->datagridValues['_sort_order'] = 'ASC';
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('position')
            ->add('title.fr')
            ->add('createdAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('position')
            ->addIdentifier('titleAdmin')
            ->add('createdAt')
            ->add('_action', null, array(
                'actions' => array(
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
        $formMapper
            ->tab('Général')
                ->add('position')
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('position')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('title.fr')
            ->add('title.en')
            ->add('title.es')
            ->add('description.fr')
            ->add('description.en')
            ->add('description.es')
        ;
    }
}
