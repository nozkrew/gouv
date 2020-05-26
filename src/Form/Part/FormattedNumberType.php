<?php

namespace App\Form\Part;

use App\Entity\Main\Cities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;

class FormattedNumberType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder->addModelTransformer(new CallbackTransformer(
                function ($int) {
                    return $int;
                },
                function ($string) {
                    return (int) str_replace(" ", "", $string);
                }
            ))
        ;
    }
    
    public function getParent() {
        return TextType::class;
    }
    
    public function getBlockPrefix(){
        return 'FormattedNumberType';
    }
}
