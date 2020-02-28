<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Form\Part\FormattedNumberType;

class StrategieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('exploitation', ChoiceType::class, array(
                'choices' => array(
                    'Nu' => "nu",
                    'Meublé' => "meublé",
                    'Colocation' => "colocation",
                    'Saisonnier' => "saisonnier",
                ),
                'multiple' => true,
                'label' => "Mode d'exploitation"
            ))
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Appartement' => "appartement",
                    'Maison' => "maison",
                    'Immeuble' => "immeuble",
                    'Parking' => "parking",
                    'Autre' => "autre"
                ),
                'multiple' => true,
                'label' => "Type de bien"
            )) 
            ->add('travaux', ChoiceType::class, array(
                'choices' => array(
                    'Aucun travaux' => "aucun travaux",
                    'Rafraichissement' => "rafraichissement",
                    'Petite rénovation' => "petite rénovation",
                    'Grosse rénovation' => "grosse rénovation"
                ),
                'label' => "Travaux à effectuer",
                'placeholder' => "Choisissez un type de travaux"
            )) 
            ->add('montant', FormattedNumberType::class, array(
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
            'csrf_token' => false
        ]);
    }
}
