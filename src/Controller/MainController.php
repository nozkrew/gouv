<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cities;
use App\Entity\Departments;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchType;
use App\Entity\IndicatorValue;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request)
    {        
        
       $cities = array();
        
        $form = $this->createForm(SearchType::class, null, array(
            'method' => 'GET'
        ));
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $param = [
                'dpt' => array_map(create_function('$d', 'return $d->getCode();'), $form->get('dpt')->getData()->toArray()),
                'population' => [
                    'min' => $form->get('populationMin')->getData(),
                    'max' => $form->get('populationMax')->getData()
                ],
                'price' => [
                    'min' => $form->get('priceMeterMin')->getData(),
                    'max' => $form->get('priceMeterMax')->getData()
                ]
            ];
            
            $cities = $this->getCitiesRepository()->findByParams($param);            
        }
        
        return $this->render('main/index.html.twig', [
            'cities' => $cities,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/{city_name}/{insee_code}")
     */
    public function detailCityAction($city_name, $insee_code){
        $city = $this->getCitiesRepository()->findOneByInseeCode($insee_code);
        
        $popByAge = $this->getIndicatorValueRepository()->findByCityAndIndicator($city, 'POP_T0');
        $evoPop = $this->getIndicatorValueRepository()->findByCityAndIndicator($city, 'POP_T1');
        $type = $this->getIndicatorValueRepository()->findByCityAndIndicator($city, 'LOG_T3');
        $popType = $this->getIndicatorValueRepository()->findByCityAndIndicator($city, 'EMP_G1');

        return $this->render('main/detail.html.twig', [
            'city' => $city,
            'popByAge' => $popByAge,
            'evoPop' => $evoPop,
            'type' => $type,
            'popType' => $popType,
        ]);
    }
    
    
    
    private function getCitiesRepository(){
        return $this->container->get('doctrine')->getRepository(Cities::class);
    }
    
    private function getIndicatorValueRepository(){
        return $this->container->get('doctrine')->getRepository(IndicatorValue::class);
    }
}
