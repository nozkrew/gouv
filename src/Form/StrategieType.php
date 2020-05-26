<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Form\Part\FormattedNumberType;
use App\Entity\Main\Strategy;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Main\ListExploitation;
use App\Entity\Main\ListTypeBien;
use App\Entity\Main\ListTravaux;

class StrategieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('exploitations', EntityType::class, array(
                'class' => ListExploitation::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => "Mode d'exploitation"
            ))
            ->add('types', EntityType::class, array(
                'class' => ListTypeBien::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => "Type de bien"
            )) 
            ->add('travaux', EntityType::class, array(
                'class' => ListTravaux::class,
                'choice_label' => 'name',
                'label' => "Travaux à effectuer",
                'placeholder' => "Choisissez un type de travaux"
            )) 
            ->add('price', FormattedNumberType::class, array(
                'label' => "Montant total de l'investissement"
            ))
            ->add('cashflow', FormattedNumberType::class, array(
                'label' => "Cashflow mensuel à atteindre"
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Strategy::class,
            //'csrf_token' => false
        ]);
    }
}
