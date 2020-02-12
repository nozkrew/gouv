<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Departments;
use App\Repository\DepartmentsRepository;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SearchCitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dpt', EntityType::class, array(
            'class' => Departments::class,
            'choice_label' => function ($department) {
                return $department->getCode()." - ".$department->getName();
            },
            'choice_value' => function ($department = null) {
                return $department ? $department->getCode() : '';
            },
            'query_builder' => function (DepartmentsRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.code', 'ASC');
            },
            'placeholder' => "SELECTIONNER",
            'label' => "Département(s)",
            'multiple' => true
        ))
        ->add('populationMin', IntegerType::class, array(
            'required'=>false,
            'label' => "Population min.",
            'attr' => array(
                'placeholder' => "Ex: 500"
            )
        ))
        ->add('populationMax', IntegerType::class, array(
            'required'=>false,
            'label' => "Population max.",
            'attr' => array(
                'placeholder' => "Ex: 20000"
            )
        ))
        ->add('priceMeterMin', IntegerType::class, array(
            'required'=>false,
            'label' => "Prix au m² min.",
            'attr' => array(
                'placeholder' => "Ex: 800"
            )
        ))
        ->add('priceMeterMax', IntegerType::class, array(
            'required'=>false,
            'label' => "Prix au m² max.",
            'attr' => array(
                'placeholder' => "Ex: 3000"
            )
        ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
