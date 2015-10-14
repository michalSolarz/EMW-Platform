<?php

namespace Acme\Bundle\EventManagerBundle\Form;

use Acme\Bundle\EventManagerBundle\Entity\Event;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaperType extends AbstractType
{
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $event = $this->event;

        $builder
            ->add('title')
            ->add('coAuthors')
            ->add('researchAdvisor')
            ->add('content', 'textarea')
            ->add('paperCategory', 'entity',
                array(
                    'required' => true,
                    'placeholder' => 'Select paper category',
                    'class' => 'Acme\Bundle\EventManagerBundle\Entity\PaperCategory',
                    'property' => 'name',
                    'query_builder' => function (EntityRepository $entityRepository) use ($event) {
                        return $entityRepository->createQueryBuilder('paperCategory')
                            ->where('paperCategory.universalPaperCategory = :universalPaperCategory')
                            ->orWhere('paperCategory.event = :event')
                            ->setParameters(array(
                                'universalPaperCategory' => true,
                                'event' => $event
                            ))
                            ->orderBy('paperCategory.name');
                    }
                ));
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
