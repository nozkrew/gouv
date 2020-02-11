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
                //modification des options du champs inseeCode
                $inseeCodeField = $form->get('inseeCode');
                $inseeCodeOptions = $inseeCodeField->getConfig()->getOptions();
                $inseeCodeType = $inseeCodeField->getConfig()->getType()->getInnerType();
                $inseeCodeOptions['data'] = $city['inseeCode'];
                $form->add('inseeCode', get_class($inseeCodeType), $inseeCodeOptions);
                
                //modification des options du champs name
                $nameField = $form->get('name');
                $nameOptions = $nameField->getConfig()->getOptions();
                $nameType = $nameField->getConfig()->getType()->getInnerType();
                $nameOptions['data'] = $city['name']." (".$city['zipCode'].")";
                $nameOptions['attr'] = array(
                                            'class' => 'form-control-plaintext',
                                            'readonly' => 'readonly'
                                        );
                $form->add('name', get_class($nameType), $nameOptions);
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
