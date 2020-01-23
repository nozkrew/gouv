<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Departments;
use App\Repository\DepartmentsRepository;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dpt', EntityType::class, array(
            'class' => Departments::class,
            'choice_label' => function ($department) {
                return $department->getCode()." - ".$department->getName();
            },
            'query_builder' => function (DepartmentsRepository $er) {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.code', 'ASC');
            }
        ))
        ->add('populationMin', NumberType::class, array(
            'required'=>false
        ))
        ->add('populationMax', NumberType::class, array(
            'required'=>false
        ))
        ->add('priceMeterMin', NumberType::class, array(
            'required'=>false
        ))
        ->add('priceMeterMax', NumberType::class, array(
            'required'=>false
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
