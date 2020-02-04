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
            ->add('priceMax', IntegerType::class, array(
                'label' => "Prix max."
            ))
            ->add('surfaceMin', IntegerType::class, array(
                'label' => "Surface min."
            ))
            ->add('name', null, array(
                'label' => 'Nom de la recherche'
            ))
            ->add('search', TextType::class, array(
                'mapped' => false,
                'required' => false,
                'label' => 'Ajouter une ville'
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
                            'name' => $city->getName(),
                            'inseeCode' => $city->getInseeCode()
                        );
                        $array[] = $tmp;
                    }
                    return $array;
                },
                function ($array) {
                    $collection = new ArrayCollection();
                    foreach($array as $c){
                        $city = $this->getCitiesRepository()->findOneByInseeCode($c['inseeCode']);
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
