<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cities;

/**
* @Route("/utility")
*/
class UtilityController extends AbstractController{
    /**
     * @Route("/cities", methods="GET")
     */
    public function cities(Request $request){
        $query = $request->query->get('query');
        if($query !== null && $query !== ""){
            $cities = $this->getCitiesRepository()->findByQuery($query);
            
            return $this->json($cities);
        }
    }
    
    private function getCitiesRepository(){
        return $this->container->get('doctrine')->getRepository(Cities::class);
    }
}
