<?php

namespace Acme\Bundle\EventManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registrationOpening', 'datetime', array('required' => true))
            ->add('registrationClosure', 'datetime', array('required' => true))
            ->add('eventWithPapers', 'checkbox', array('required' => false))
            ->add('papersPerParticipant', 'text', array('required' => false))
            ->add('papersRegistrationOpening', 'datetime')
            ->add('papersRegistrationClosure', 'datetime')
            ->add('name', 'text', array('required' => true))
            ->add('eventBeginning', 'date', array('required' => true))
            ->add('eventEnd', 'date', array('required' => true))
            ->add('eventIsVisible', 'checkbox', array('required' => false));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\Bundle\EventManagerBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_bundle_eventmanagerbundle_event';
    }
}
