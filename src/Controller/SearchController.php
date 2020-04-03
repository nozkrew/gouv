<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cities;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchType;
use App\Entity\Search;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
* @Route("/recherche")
*/
class SearchController extends AbstractController
{
    
    private const LINKS_DEMO = [
        "https://www.laforet.com/acheter/rechercher?filter%5Bcities%5D=40088&filter%5Bmax%5D=200000&filter%5Bsurface%5D=80",
        "https://www.bourse-immobilier.fr/achat-maison-appartement-immeuble-dax?quartiers=40088&surface=80&sterr=0&prix=-200000&typebien=1-2-9&nbpieces=1-2-3-4-5&og=0&where=Dax-__40100_&_b=1&_p=0&tyloc=2&neuf=1&ancien=1&ids=40088",
        "https://www.cabinet-bedin.com/recherche/achat/dax-40100/maison,appartement,immeuble-mixte?prix-max=200000&surface-min=80"
    ];


    /**
     * @Route("/")
     * @Route("/demo")
     */
    public function index(Request $request)
    {
        
        $security = $this->container->get('security.authorization_checker');
        if($security->isGranted('IS_AUTHENTICATED_FULLY')){
            $searches = $this->getSearchRepository()->findByUser($this->getUser());
        }
        else{            
            $searches = array($this->getDemoSearch());
        }
        
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
                $this->addFlash("danger", "Recherche introuvable");
                return $this->redirect($this->generateUrl('app_search_index'));
            }
        }
        
        $form = $this->createForm(SearchType::class, $search);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            try {
                
                $em = $this->getDoctrine()->getManager();
                if($search->getId() === null){
                    $em->persist($search);
                }
                $em->flush();
                $this->addFlash("success", "Recherche enregistrée");
                if($search->getId() !== null){
                    return $this->redirect($this->generateUrl('app_search_edit_1', array('id'=>$search->getId())));
                }
                
                return $this->redirect($this->generateUrl('app_search_edit'));
                
            } catch (\Exception $ex) {
                $this->addFlash("danger", "Erreur lors de l'enregistrement. Veuillez ré-essayer");
            }
        }
        
        return $this->render('search/edit.html.twig', [
            'form' => $form->createView(),
            'search' => $search
        ]);
    }
    
    /**
     * @Route("/{id}/supprimer", requirements={"id"="\d+"})
     * @Method({"POST"})
     */
    public function delete(Request $request, $id){
        $search = $this->getSearchRepository()->findOneById($id);
        if($search === null || $search->getUser() !== $this->getUser()){
            $this->addFlash("danger", "Recherche introuvable");
            return $this->redirect($this->generateUrl('app_search_index'));
        }
        
        try{
            $em = $this->getDoctrine()->getManager();
            $em->remove($search);
            $em->flush();
            $this->addFlash("success", "Recherche supprimée");
            return $this->redirect($this->generateUrl('app_search_index'));
        } catch (\Exception $ex) {
            $this->addFlash("danger", "Recherche introuvable");
        }
    }
    
    /**
     * @Route("/{id}/lien/{index}", requirements={"id"="\d+", "index"="\d+"})
     * @Route("/demo/lien/{index}", requirements={"index"="\d+"})
     */
    public function lien(Request $request, $id = null, $index){
        
        if($request->get('_route') == 'app_search_lien_1'){
            
            return $this->render('search/lien.html.twig', [
                'search' => $this->getDemoSearch(),
                'url' => self::LINKS_DEMO[$index],
                'index' => $index,
                'next' => isset(self::LINKS_DEMO[$index + 1]) ? true : false,
                'previous' => isset(self::LINKS_DEMO[$index - 1]) ? true : false,
            ]);
        }
        
        $search = $this->getSearchRepository()->findOneById($id);
        
        if($search === null || $search->getUser() !== $this->getUser()){
            $this->addFlash("danger", "Recherche introuvable");
            return $this->redirect($this->generateUrl('app_search_index'));
        }
        
        if(!isset($search->getLinks()[$index])){
            $this->addFlash("danger", "Lien introuvable");
            return $this->redirect($this->generateUrl('app_search_index'));
        }
        
        return $this->render('search/lien.html.twig', [
            'search' => $search,
            'url' => $search->getLinks()[$index],
            'index' => $index,
            'next' => isset($search->getLinks()[$index + 1]) ? true : false,
            'previous' => isset($search->getLinks()[$index - 1]) ? true : false,
        ]);
    }

    private function getDemoSearch():Search {
        
        $dax = $this->getCitiesRepository()->findOneBySlug('dax');
        
        $search = new Search();
        $search->setName('[Exemple] Colocation à Dax');
        $search->setPriceMax(200000);
        $search->setSurfaceMin(80);
        $search->addCity($dax);
        $search->setLinks(self::LINKS_DEMO);
        
        $em = $this->getDoctrine()->getManager();
        $em->detach($search);
        
        return $search;
    }

    private function getCitiesRepository(){
        return $this->container->get('doctrine')->getRepository(Cities::class);
    }

    private function getSearchRepository(){
        return $this->container->get('doctrine')->getRepository(Search::class);
    }
}
