<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cities;
use App\Entity\Departments;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request)
    {        
        
        $departments = $this->getDepartmentsRepository()->findBy(array(),array(
            'name' => 'ASC'
        ));
        
        if($request->query->get('dpt_code') !== null && $request->query->get('dpt_code') !== ""){
            $cities = $this->getCitiesRepository()->findBy(array(
                'departmentCode' => $request->query->get('dpt_code')
            ));
        }
        else{
            $cities = $this->getCitiesRepository()->findAll();
        }
        
        return $this->render('main/index.html.twig', [
            'departments' => $departments,
            'cities' => $cities,
        ]);
    }
    
    private function getCitiesRepository(){
        return $this->container->get('doctrine')->getRepository(Cities::class);
    }
    
    private function getDepartmentsRepository(){
        return $this->container->get('doctrine')->getRepository(Departments::class);
    }
}
