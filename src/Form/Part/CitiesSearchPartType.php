<?php

namespace App\Form\Part;

use App\Entity\Cities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class CitiesSearchPartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('inseeCode', HiddenType::class)
            ->add('name', TextType::class, array(
                'attr' => array(
                    'class' => 'form-control-plaintext',
                    'readonly' => 'readonly'
                ),
                'label' => null
            ))
        ;
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            
            $form = $event->getForm();
            $city = $event->getData();
            
            if($city !== null){
                
                //TODO : a ameliorer pour reprendre la configuration du champs
                
                $form->add('inseeCode', HiddenType::class, array(
                    'data' => $city['inseeCode']
                ));
                $form->add('name', TextType::class, array(
                    'data' => $city['name']." (".$city['zipCode'].")",
                    'attr' => array(
                        'class' => 'form-control-plaintext',
                        'readonly' => 'readonly'
                    )
                ));
            }
        });
    }
    
    public function getBlockPrefix(){
        return 'CitiesSearchPartType';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
