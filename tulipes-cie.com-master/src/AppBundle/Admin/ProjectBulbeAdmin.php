<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Bulbe\AbstractBulbe;
use Caramia\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProjectBulbeAdmin extends AbstractAdmin
{
    public function configure()
    {
        parent::configure();

        $this->datagridValues['_sort_by']    = 'createdAt';
        $this->datagridValues['_sort_order'] = 'DESC';
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('createdAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('titleProject')
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
            ->tab("Général")
                ->add('blocSize', 'choice', [
                    'choices' => AbstractBulbe::getBlocSizeList(),
                    'required' => true,
                ])
                ->add('bulbeProject', null, [
                    'required' => true,
                ])
                ->add('isDispInProject', null, [
                    /*'data' => true*/
                ])
            ->end()
        ;
    }

    public function getOptionForForm($name)
    {
        if ($name == 'title') {
            return ['label' => 'Sous-titre',];
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('size')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('isDispInProject')
        ;
    }
}
