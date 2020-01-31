<?php

namespace App\Form;

use App\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Departments;
use App\Entity\Cities;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class SearchType extends AbstractType
{
    
    private $manager;
    
    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('priceMax', IntegerType::class)
            ->add('surfaceMin', IntegerType::class)
            ->add('name', null)
            ->add('department', EntityType::class, array(
                'mapped' => false,
                'class' => Departments::class,
                'choice_label' => 'name'
            ))
        ;
        
        $formModifier = function (FormInterface $form, Departments $department = null) {            
            $cities = null === $department ? [] : $this->getCitiesRepository()->findByDepartmentCode($department->getCode());
            
            $form->add('cities', EntityType::class, array(
                'class' => Cities::class,
                'choice_label' => 'name',
                'choices' => $cities,
                'multiple' => true
            ));
        };
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
                $department = $event->getForm()->get('department')->getData();
                $formModifier($event->getForm(), $department);
            }
        );
        
        $builder->get('department')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($formModifier) {
                $department = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $department);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
        ]);
    }
    
    private function getCitiesRepository(){
        return $this->manager->getRepository(Cities::class);
    }
}
