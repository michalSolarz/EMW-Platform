<?php

namespace Acme\Bundle\EventManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaperType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status')
            ->add('title')
            ->add('coAuthors')
            ->add('researchAdvisor')
            ->add('content')
            ->add('paperCategory')
            ->add('event');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\Bundle\EventManagerBundle\Entity\Paper'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_bundle_eventmanagerbundle_paper';
    }
}
