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
            ->add('createdAt')
            ->add('lastEditedAt')
            ->add('registrationOpening')
            ->add('registrationClosure')
            ->add('eventWithPapers')
            ->add('papersRegistrationOpening')
            ->add('papersRegistrationClosure')
            ->add('eventName')
            ->add('eventBeginning')
            ->add('eventEnd')
            ->add('eventIsVisible')
            ->add('eventUniqueHash')
            ->add('createdBy')
            ->add('lastEditedBy')
            ->add('eventParticipants');
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
