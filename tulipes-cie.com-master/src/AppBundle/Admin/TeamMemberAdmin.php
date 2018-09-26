<?php

namespace AppBundle\Admin;

use Caramia\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\Type as SonataForm;

use Symfony\Component\Validator\Constraints as Assert;
use Caramia\MediaBundle\Annotation\MediaConstraints as MediaAssert;
use Caramia\MediaBundle\Form\MediaType;

class TeamMemberAdmin extends AbstractAdmin
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
            ->add('id')
            ->add('firstName')
            ->add('lastName')
            ->add('isActive')
            ->add('createdAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('firstName')
            ->add('lastName')
            ->add('isActive')
            ->add('createdAt')
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

/*    public function getOptionForForm($name)
    {
        if ($name == 'description') {
            return ['config_name' => 'default'];
        }
    }*/

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Général')
                ->add('firstName')
                ->add('lastName')
                ->add('image', MediaType::class, array(
                    'required' => true
                ))
                ->add('rollImage', MediaType::class, array(
                    'required' => true
                ))
                // ->add('description')
                ->add('isActive', null, [
                    'attr' => ['checked' => 'checked'],
                ])
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
            ->add('firstName')
            ->add('lastName')
            ->add('image')
            ->add('rollImage')
            // ->add('description')
            ->add('isActive')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
