<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cities;
use App\Entity\Departments;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchCitiesType;
use App\Entity\IndicatorValue;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\CalculateurType;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request)
    {        
        
       $cities = array();
        
        $form = $this->createForm(SearchCitiesType::class, null, array(
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
     * @Route("/ville/{city_name}/{insee_code}")
     */
    public function detailCity($city_name, $insee_code){
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
    
    /**
     * @Route("/favoris")
     */
    public function favoris(){
        $cities = $this->getCitiesRepository()->findByUsers($this->getUser());
        
        return $this->render('main/favoris.html.twig', [
            'cities' => $cities,
        ]);
    }
    
    /**
     * @Route("/favoris/add/{insee_code}", options={"expose"=true}, methods={"POST"})
     */
    public function favorisAdd(Request $request, $insee_code){
        $city = $this->getCitiesRepository()->findOneByInseeCode($insee_code);
        
        if($city === null){
            //erreur
        }
        
        //Si la ville est deja en favoris, on l'enlève
        if($this->getUser()->getCities()->contains($city)){
            $this->getUser()->removeCity($city);
        }
        else{
            $this->getUser()->addCity($city);
        }
        
        try{
            $em = $this->getDoctrine()->getManager();
            $em->flush();
        } catch (\Exception $ex) {
            //erreur
        }
        
        if($request->isXmlHttpRequest()){
            $form = $this->createFormBuilder()
                    ->setAction($this->generateUrl('app_main_favorisadd', array('insee_code'=>$insee_code)))
                    ->setMethod('GET')
                    ->getForm();
            
            return new JsonResponse(array(
                'error' => false,
                'html' => $this->renderView('main/components/formFavoris.html.twig', array(
                    'city' => $city
                ))
            ));
        }
        
        //return si ce n'est pas du xml
    }
    
    /**
     * @Route("/calculateur")
     */
    public function calculateur(){
        
        $form = $this->createForm(CalculateurType::class);
        
        return $this->render('main/calculateur.html.twig', [
            'form' => $form->createView()
        ]);
    }




    private function getCitiesRepository(){
        return $this->container->get('doctrine')->getRepository(Cities::class);
    }
    
    private function getIndicatorValueRepository(){
        return $this->container->get('doctrine')->getRepository(IndicatorValue::class);
    }
}
