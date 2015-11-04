<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 04.11.15
 * Time: 15:02
 */

namespace Acme\Bundle\EventManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class FacultyDataType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'forms.user_data.faculty.child.name.label'
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
        return 'faculty';
    }
}