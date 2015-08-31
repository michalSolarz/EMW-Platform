<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 25.08.15
 * Time: 17:50
 */

namespace Acme\Bundle\EventManagerBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UniversityDataType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'forms.user_data.university.child.name.label'
            ))
            ->add('address', 'text', array(
                'label' => 'forms.user_data.university.child.address.label'
            ));

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'forms'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'university';
    }
}