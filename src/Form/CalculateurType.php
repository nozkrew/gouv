<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CalculateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('prix', IntegerType::class, array(
                    'label' => "Prix d'achat",
                    'attr' => array(
                        'placeholder' => "Ex: 150000"
                    )
                ))
                ->add('loyer', IntegerType::class, array(
                    'label' => "Loyer mensuel estimés",
                    'attr' => array(
                        'placeholder' => "Ex: 800"
                    )
                ))
                ->add('metreCarre', IntegerType::class, array(
                    'label' => "m²",
                    'attr' => array(
                        'placeholder' => "Ex: 100"
                    )
                ))
                ->add('apport', IntegerType::class, array(
                    'label' => "Apport",
                    'attr' => array(
                        'placeholder' => "Ex: 10000"
                    )
                ))
                ->add('fraisNotaire', IntegerType::class, array(
                    'label' => "Frais de notaire",
                    'attr' => array(
                        'placeholder' => "Ex: 12330"
                    )
                ))
                ->add('fraisNotaireEstime', TextType::class, array(
                    'label' => null,
                    'attr' => array(
                        'readonly' => 'readonly'
                    )
                ))
                ->add('garantie', IntegerType::class, array(
                    'label' => "Garantie banque",
                    'attr' => array(
                        'placeholder' => "Ex: 4073"
                    )
                ))
                ->add('garantieEstimation', TextType::class, array(
                    'label' => null,
                    'attr' => array(
                        'readonly' => 'readonly'
                    )
                ))
                ->add('travaux', IntegerType::class, array(
                    'label' => "Travaux",
                    'attr' => array(
                        'placeholder' => "Ex: 50400"
                    )
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
