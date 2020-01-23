<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cities;
use App\Entity\Departments;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchType;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request)
    {        
        
        //traiter le formulaire ici
        
        if($request->query->get('dpt') !== null && $request->query->get('dpt') !== ""){
            $cities = $this->getCitiesRepository()->findBy(array(
                'departmentCode' => $request->query->get('dpt')
            ));
        }
        else{
            $cities = $this->getCitiesRepository()->findAll();
        }
        
        $form = $this->createForm(SearchType::class, null, array(
            'method' => 'GET'
        ));
        
        return $this->render('main/index.html.twig', [
            'cities' => $cities,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/{city_id}")
     */
    public function detailCityAction($city_id){
        $city = $this->getCitiesRepository()->find($city_id);
        
        return $this->render('main/detail.html.twig', [
            'city' => $city,
        ]);
    }
    
    
    
    private function getCitiesRepository(){
        return $this->container->get('doctrine')->getRepository(Cities::class);
    }
    
    private function getDepartmentsRepository(){
        return $this->container->get('doctrine')->getRepository(Departments::class);
    }
}
