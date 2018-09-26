<?php

namespace AppBundle\Form;

use AppBundle\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $allowedFileMimeTypes = [
            "application/pdf",
            "application/x-pdf",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        ];

        $builder
            ->add('company', null, [
                'required' => true,
            ])
            ->add('name', null, [
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'required' => true,
            ])
            ->add('telephone', null, [
                'required' => false,
            ])
            ->add('object', ChoiceType::class, [
                'choices'     => Contact::getObjectsList(),
                'placeholder' => 'contact.form.object',
                'required'    => true,
            ])
            ->add('file', FileType::class, [
                'required' => false,
                'attr' => [
                    'accept' => implode(',', $allowedFileMimeTypes),
                ],
                'constraints' => [
                    new Assert\File([
                        'mimeTypes' => $allowedFileMimeTypes,
                        'mimeTypesMessage' => "La pièce jointe doit être un fichier Word ou un PDF"
                    ])
                ]
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
            ])
            ->add('send',  SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Contact::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contact';
    }


}
