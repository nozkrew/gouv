<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Main\ListTravaux;

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
                ->add('ameublement', IntegerType::class, array(
                    'label' => "Ameublement",
                    'attr' => array(
                        'placeholder' => "Ex: 6000"
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
                ->add('travauxAide', EntityType::class, array(
                    'class' => ListTravaux::class,
                    'label' => null,
                    'choice_label' => 'name',
                    'choice_value' => 'priceMeter',
                    'placeholder' => 'SELECTIONNER'
                ))
                ->add('dureePret', IntegerType::class, array(
                    'label' => "Durée du prêt",
                    'attr' => array(
                        'placeholder' => "Ex: 20",
                        'max' => 35
                    )
                ))
                ->add('tauxPret', IntegerType::class, array(
                    'label' => "Taux bancaire",
                    'attr' => array(
                        'placeholder' => "Ex: 1.5",
                        'step'=> '0.01',
                        'min' => 0,
                        'max' => 100
                    )
                ))
                ->add('taxeFonciere', IntegerType::class, array(
                    'label' => "Taxe foncière",
                    'attr' => array(
                        'placeholder' => "Ex: 1300"
                    )
                ))
                ->add('chargesCopro', IntegerType::class, array(
                    'label' => "Charges de copropriété",
                    'attr' => array(
                        'placeholder' => "Ex: 1300"
                    )
                ))
                ->add('chargesBien', IntegerType::class, array(
                    'label' => "Entretien du bien",
                    'attr' => array(
                        'placeholder' => "Ex: 5",
                        'min' => 0,
                        'max' => 100
                    )
                ))
                ->add('chargesBienTotal', TextType::class, array(
                    'label' => null,
                    'attr' => array(
                        'readonly' => 'readonly'
                    )
                ))
                ->add('gerance', IntegerType::class, array(
                    'label' => "Frais de gérance",
                    'attr' => array(
                        'placeholder' => "Ex: 8",
                        'min' => 0,
                        'max' => 100
                    )
                ))
                ->add('geranceTotal', TextType::class, array(
                    'label' => null,
                    'attr' => array(
                        'readonly' => 'readonly'
                    )
                ))
                ->add('assurancePno', IntegerType::class, array(
                    'label' => "Assurance PNO",
                    'attr' => array(
                        'placeholder' => "Ex: 200"
                    )
                ))
                ->add('comptabilite', IntegerType::class, array(
                    'label' => "Comptabilité",
                    'attr' => array(
                        'placeholder' => "Ex: 700"
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
