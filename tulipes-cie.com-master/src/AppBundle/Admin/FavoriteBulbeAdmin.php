<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Bulbe\AbstractBulbe;
use Caramia\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Validator\Constraints as Assert;
use Caramia\MediaBundle\Annotation\MediaConstraints as MediaAssert;
use Caramia\MediaBundle\Form\MediaType;

class FavoriteBulbeAdmin extends AbstractAdmin
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
            ->addIdentifier('tilteAdmin')
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
                ->add('favoriteBulbeUrl', 'url', [
                    'required' => true
                ])
                ->add('thumb1Image', MediaType::class, array(
                    'required' => true
                ))
                ->add('thumb2Image', MediaType::class, array(
                    'required' => false
                ))
                ->add('thumb3Image', MediaType::class, array(
                    'required' => false
                ))
                ->add('thumb4Image', MediaType::class, array(
                    'required' => false
                ))
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
            ->add('size')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('favoriteBulbeUrl')
        ;
    }
}
