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
use App\Form\StrategieType;
use App\Entity\Strategy;

class MainController extends AbstractController
{    
    /**
     * @Route("/")
     */
    public function index(){
        //définir la page d'acceuil
        return $this->redirect($this->generateUrl('main'));
    }


    /**
     * @Route("/ville", name="main")
     */
    public function ville(Request $request)
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
     * @Route("/strategie")
     */
    public function strategie(Request $request)
    {  
        //Si l'utilisateur n'est pas connecté
        if(!$this->isGranted('ROLE_USER')){
            $strategie = new Strategy();
        }
        //Si l'utilisateur est connecté
        else{
            $strategie = $this->getStrategyRepository()->findOneBy(array(
                'user' => $this->getUser()
            ));
            
            if($strategie === null){
                $strategie = new Strategy();
                $strategie->setUser($this->getUser());
            }
        }        
        
        $form = $this->createForm(StrategieType::class, $strategie, array(
            //'method' => 'GET'
        ));
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            //Si l'utilisateur est connecté, on enregistre sa stratégie
            if($this->isGranted('ROLE_USER')){
                try{
                    
                    if($strategie->getId() === null){
                        $em->persist($strategie);
                    }
                    $em->flush();
                } catch (\Exception $ex) {
                    $this->addFlash("error", "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer");
                }
            }
            else{
                $em->detach($strategie);
            }

        }
        
        return $this->render('main/strategie.html.twig', [
            'form' => $form->createView(),
            'strategy' =>$strategie
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
    
    private function getStrategyRepository(){
        return $this->container->get('doctrine')->getRepository(Strategy::class);
    }
    
    private function getIndicatorValueRepository(){
        return $this->container->get('doctrine')->getRepository(IndicatorValue::class);
    }
}
