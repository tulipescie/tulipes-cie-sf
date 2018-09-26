<?php

namespace AppBundle\Admin;

use  Caramia\MediaBundle\Admin\MediaAdmin as BaseAdmin;

use Caramia\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\CoreBundle\Form\Type as SonataFormType;

use Sonata\CoreBundle\Model\Metadata;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MediaAdmin extends BaseAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->tab('Général');
        parent::configureFormFields($formMapper);
        $formMapper->end();
    }

    public function getOptionForForm($name)
    {
        if ($name == 'description') {
            return [
                'empty_data' => '',
                'required' => false,
            ];
        }
    }

}
