<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Main\Cities;

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
            $cities = array();
            $results = $this->getCitiesRepository()->findByQuery($query);
            foreach($results as $city){
                $cities[] = array(
                    'inseeCode' => $city['inseeCode'],
                    'zipCode' => $city['zipCode'],
                    'name' => $city['name'],
                    'url' => $this->generateUrl('app_main_detailcity', array(
                        'city_name' => str_replace(" ", "-", $city['slug']),
                        'insee_code' => $city['inseeCode']
                    ))
                );
            }
            
            return $this->json($cities);
        }
    }
    
    private function getCitiesRepository(){
        return $this->container->get('doctrine')->getRepository(Cities::class);
    }
}
