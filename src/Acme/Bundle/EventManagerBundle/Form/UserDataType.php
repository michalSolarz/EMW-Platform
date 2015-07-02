<?php

namespace Acme\Bundle\EventManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserDataType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt')
            ->add('lastEditedAt')
            ->add('gender')
            ->add('nationality')
            ->add('fieldOfStudies')
            ->add('yearOfStudies')
            ->add('phoneNumber')
            ->add('isVegetarian')
            ->add('needsVisa')
            ->add('acceptedTerms')
            ->add('photoUniqueId')
            ->add('passportUniqueId')
            ->add('createdBy')
            ->add('lastEditedBy')
            ->add('country')
            ->add('university')
            ->add('faculty')
            ->add('user');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\Bundle\EventManagerBundle\Entity\UserData'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_bundle_eventmanagerbundle_userdata';
    }
}
