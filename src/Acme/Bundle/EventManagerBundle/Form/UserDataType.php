<?php

namespace Acme\Bundle\EventManagerBundle\Form;

use Acme\Bundle\EventManagerBundle\Model\CountriesDataTransformer;
use Acme\Bundle\EventManagerBundle\Model\CreationHandler;
use Acme\Bundle\EventManagerBundle\Model\FacultiesDataTransformer;
use Acme\Bundle\EventManagerBundle\Model\UniversityDataTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserDataType extends AbstractType
{
    private $entityManager;
    private $creationHandler;

    public function __construct(ObjectManager $entityManager, CreationHandler $creationHandler)
    {
        $this->entityManager = $entityManager;
        $this->creationHandler = $creationHandler;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender',
                'choice', array(
                    'choices' => array(
                        'f' => 'forms.user_data.gender.choices.female',
                        'm' => 'forms.user_data.gender.choices.male'
                    ),
                    'label' => 'forms.user_data.gender.label'))
            ->add('nationality',
                'text', array(
                    'label' => 'forms.user_data.nationality.label'))
            ->add('fieldOfStudies',
                'text', array(
                    'label' => 'forms.user_data.fieldOfStudies.label'))
            ->add('yearOfStudies',
                'text', array(
                    'label' => 'forms.user_data.yearOfStudies.label'))
            ->add('phoneNumber',
                'text', array(
                    'label' => 'forms.user_data.phoneNumber.label'))
            ->add('isVegetarian',
                'checkbox', array(
                    'required' => false,
                    'value' => true,
                    'label' => 'forms.user_data.isVegetarian.label'))
            ->add('needsVisa',
                'checkbox', array(
                    'required' => false,
                    'value' => true,
                    'label' => 'forms.user_data.needsVisa.label'))
            ->add('acceptedTerms',
                'checkbox', array(
                    'value' => true,
                    'empty_data' => false,
                    'label' => 'forms.user_data.acceptedTerms.label'))
            ->add('country',
                'text', array(
                    'label' => 'forms.user_data.country.label'))
            ->add('university',
                new UniversityDataType(), array(
                    'label' => 'forms.user_data.university.label'))
            ->add('faculty',
                new FacultyDataType(), array(
                    'label' => 'forms.user_data.faculty.label'))
            ->add('surname',
                'text', array(
                    'label' => 'forms.user_data.surname.label'))
            ->add('name',
                'text', array(
                    'label' => 'forms.user_data.name.label'));

        $builder->get('country')->addModelTransformer(new CountriesDataTransformer($this->entityManager));
        $builder->get('university')->addModelTransformer(new UniversityDataTransformer($this->entityManager, $this->creationHandler));
        $builder->get('faculty')->addModelTransformer(new FacultiesDataTransformer($this->entityManager, $this->creationHandler));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\Bundle\EventManagerBundle\Entity\UserData',
            'translation_domain' => 'forms'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_data';
    }
}
