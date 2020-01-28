<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CalculateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('prix', IntegerType::class, array(
                    'label' => "Prix de l'annonce"
                ))
                ->add('loyer', IntegerType::class, array(
                    'label' => "Loyer mensuel estimés"
                ))
                ->add('metreCarre', IntegerType::class, array(
                    'label' => "m²"
                ))
                ->add('priceMetreCarre', IntegerType::class, array(
                    'label' => "null"
                ))
                ->add('apport', IntegerType::class, array(
                    'label' => "Apport"
                ))
                ->add('fraisNotaire', IntegerType::class, array(
                    'label' => "Frais de notaire"
                ))
                ->add('garantie', IntegerType::class, array(
                    'label' => "Garantie banque"
                ))
                ->add('travaux', IntegerType::class, array(
                    'label' => "Travaux"
                ))
                ->add('travauxAide', ChoiceType::class, array(
                    'label' => null,
                    'choices' => array(
                        "Création" => 800,
                        "Rénovation" => 630,
                        "Rafraichissement" => 260,
                    ),
                    'placeholder' => 'SELECTIONNER'
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
