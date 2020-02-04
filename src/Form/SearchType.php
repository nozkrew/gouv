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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\Part\CitiesSearchPartType;
use Symfony\Component\Form\CallbackTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\CitiesRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
            ->add('search', TextType::class, array(
                'attr' => array(
                    'class' => "autocomplete"
                ),
                'mapped' => false,
                'required' => false
            ))
            ->add('cities', CollectionType::class, array(
                'entry_type' => CitiesSearchPartType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true
            ))
        ;
        
        $builder->get('cities')->addModelTransformer(new CallbackTransformer(
                function ($collection) {
                    $array = [];
                    foreach($collection as $city){
                        $tmp = array(
                            'zipCode' => $city->getZipCode(),
                            'name' => $city->getName()
                        );
                        $array[] = $tmp;
                    }
                    return $array;
                },
                function ($array) {
                    $collection = new ArrayCollection();
                    foreach($array as $c){
                        $city = $this->getCitiesRepository()->findOneByZipCode($c['zipCode']);
                        if($city !== null){
                            $collection->add($city);
                        }
                    }
                    return $collection;
                }
            ))
        ;
        
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
