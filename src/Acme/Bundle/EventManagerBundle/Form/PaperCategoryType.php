<?php

namespace Acme\Bundle\EventManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaperCategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('universalPaperCategory', 'checkbox',
                array(
                    'required' => false,
                    'value' => true))
            ->add('event', 'entity',
                array(
                    'required' => false,
                    'placeholder' => 'Not assigned to event',
                    'class' => 'Acme\Bundle\EventManagerBundle\Entity\Event'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\Bundle\EventManagerBundle\Entity\PaperCategory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_bundle_eventmanagerbundle_papercategory';
    }
}
