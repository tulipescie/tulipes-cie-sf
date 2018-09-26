<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Filter\ActivityFilter;
use AppBundle\Entity\Filter\AwardFilter;
use AppBundle\Entity\Filter\CustomerFilter;
use AppBundle\Entity\Filter\DirectorFilter;
use AppBundle\Entity\Filter\InteractifFilter;
use AppBundle\Entity\Filter\TechFilter;
use AppBundle\Entity\Filter\ThematicFilter;
use AppBundle\Entity\Filter\YearFilter;
use Caramia\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\Type as SonataForm;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Validator\Constraints as Assert;
use Caramia\MediaBundle\Annotation\MediaConstraints as MediaAssert;
use Caramia\MediaBundle\Form\MediaType;

class ProjectAdmin extends AbstractAdmin
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
            ->add('title')
            ->add('isNotShow')
            ->add('onlineAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('isNotShow')
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
                ->add('title')
                ->add('headerImage', MediaType::class)
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
                ->add('thumb5Image', MediaType::class, array(
                    'required' => false
                ))
                ->add('videoUrl', 'url', [
                    'required' => true
                ])
                ->add('isNotShow')
                ->add('onlineAt', 'sonata_type_date_picker')
                ->add('filtersActivity', SonataForm\ModelType::class, [
                    'multiple' => true,
                    'class' => ActivityFilter::class,
                    'property' => 'name.fr',
                    'required' => false,

                ])
                ->add('filtersThematic', SonataForm\ModelType::class, [
                    'multiple' => true,
                    'class' => ThematicFilter::class,
                    'property' => 'name.fr',
                    'required' => false,
                ])
                ->add('filtersAward', SonataForm\ModelType::class, [
                    'multiple' => true,
                    'class' => AwardFilter::class,
                    'property' => 'name.fr',
                    'required' => false,
                ])
                ->add('filtersTech', SonataForm\ModelType::class, [
                    'multiple' => true,
                    'class' => TechFilter::class,
                    'property' => 'name.fr',
                    'required' => false,
                ])
                ->add('filtersCustomer', SonataForm\ModelType::class, [
                    'multiple' => true,
                    'class' => CustomerFilter::class,
                    'property' => 'name.fr',
                    'required' => false,
                ])
                ->add('filtersDirector', SonataForm\ModelType::class, [
                    'multiple' => true,
                    'class' => DirectorFilter::class,
                    'property' => 'name.fr',
                    'required' => false,
                ])
            ->end()
        ;
    }

    public function getOptionForForm($name)
    {
        if ($name == 'description') {
            return ['config_name' => 'default'];
        } else if ($name == 'content') {
            return ['config_name' => 'project_content',];
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('headerImage', null, array(), 'entity', array(
                'class' => 'AppBundle\Entity\Media',
                'choice_label' => 'title',
            ))
            ->add('thumb1Image', null, array(), 'entity', array(
                'class' => 'AppBundle\Entity\Media',
                'choice_label' => 'title',
            ))
            ->add('thumb2Image', null, array(), 'entity', array(
                'class' => 'AppBundle\Entity\Media',
                'choice_label' => 'title',
            ))
            ->add('thumb3Image', null, array(), 'entity', array(
                'class' => 'AppBundle\Entity\Media',
                'choice_label' => 'title',
            ))
            ->add('thumb4Image', null, array(), 'entity', array(
                'class' => 'AppBundle\Entity\Media',
                'choice_label' => 'title',
            ))
            ->add('thumb5Image', null, array(), 'entity', array(
                'class' => 'AppBundle\Entity\Media',
                'choice_label' => 'title',
            ))
            ->add('videoUrl')
            // ->add('content')
            ->add('isNotShow')
            ->add('onlineAt')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }
}
