<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cities;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchType;
use App\Entity\Search;

/**
* @Route("/recherche")
*/
class SearchController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request)
    {
        
        $searches = $this->getSearchRepository()->findByUser($this->getUser());
        
        return $this->render('search/index.html.twig', [
            'searches' => $searches
        ]);
    }
    
    /**
     * @Route("/editer")
     * @Route("/{id}/editer", requirements={"id"="\d+"})
     */
    public function edit(Request $request, $id = null)
    {
        
        if($id === null){
            $search = new Search();
            $search->setUser($this->getUser());
        }
        else{
            $search = $this->getSearchRepository()->findOneById($id);
            if($search === null || $search->getUser() !== $this->getUser()){
                $this->addFlash("error", "Recherche introuvable");
                return $this->redirect($this->generateUrl('app_search_index'));
            }
        }
        
        $form = $this->createForm(SearchType::class, $search);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($search);
                $em->flush();
                $this->addFlash("success", "Recherche enregistrée");
                return $this->redirect($this->generateUrl('app_search_edit'));
                
            } catch (\Exception $ex) {
                $this->addFlash("error", "Erreur lors de l'enregistrement. Veuillez ré-essayer");
            }
        }
        
        return $this->render('search/edit.html.twig', [
            'form' => $form->createView(),
            'search' => $search
        ]);
    }
    


    private function getSearchRepository(){
        return $this->container->get('doctrine')->getRepository(Search::class);
    }
}
