<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Cities;
use App\Entity\Prices;
use App\Entity\Population;
use Symfony\Component\Console\Helper\ProgressBar;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Entity\IndicatorValue;
use App\Entity\Indicator;

class RecoverDataCommand extends Command
{    
    private $container;
    protected static $defaultName = 'app:recover-data';
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("Commande de récupération des données")
            ->addArgument('depCode', InputArgument::OPTIONAL, 'Code du département')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $depCode = $input->getArgument('depCode');
        
        if($depCode){
            $cities = $this->getCitiesRepository()->findBy(array(
                "departmentCode" => $depCode
            ));
        }
        else{
            $cities = $this->getCitiesRepository()->findAll();
        }
        
        $indicators = $this->getIndicatorRepository()->findAll();
                        
        // creates a new progress bar (50 units)
        $progressBar = new ProgressBar($output, count($cities));

        // starts and displays the progress bar
        $progressBar->start();
        
        $em = $this->container->get('doctrine')->getManager();
        
        $client = new Client();
        
        foreach($cities as $city){
    
            //Gestion du prix au m²
            $priceMeter = null;
            $crawler = $client->request('GET', 'https://www.rendementlocatif.com/investissement/villes/'.$city->getName().'/'.$city->getZipCode());
            $crawler->filter('.report_sub_block .value')->each(function ($node) use (&$priceMeter) {
                if(strpos($node->text(), "/m2") !== false){
                    $priceMeter = str_replace("€ /m2", "", $node->text());
                    $priceMeter = str_replace(" ", "", $priceMeter);
                }
            });
            
            //Gestion des indicateur INSEE
            $crawler = $client->request('GET', 'https://www.insee.fr/fr/statistiques/2011101?geo=COM-'.$city->getInseeCode());
            
            //POP T1 entete tableau
            $popTitle = array();
            //Valeur
            $popValue = array();
            try{
                $crawler->filter('#produit-tableau-POP_T1 tbody tr')
                        ->first()
                        ->children()
                        ->each(function (Crawler $node, $i) use (&$popTitle) {
                            if($i !== 0){
                                $year = str_replace('(*)', "", $node->text());
                                $popTitle[] = $year;
                            }
                        });
                $crawler->filter('#produit-tableau-POP_T1 tbody tr')
                        ->eq(1)
                        ->children()
                        ->each(function (Crawler $node, $i) use (&$popValue) {
                            if($i !== 0){
                            //Ligne avec les valeur que l'on souhaite
                                $popValue[] = $node->text();
                            }
                        });
            } catch (\Exception $ex) {

            }
                    
            $popCombine = array_combine( $popTitle, $popValue );
            
            //LOG_T3
            $piecesCombine = array();
            try{
                $crawler->filter('#produit-tableau-LOG_T3 tr')
                        ->each(function (Crawler $node, $i) use (&$piecesCombine) {
                            if($i > 1){
                                $piecesCombine[$node->filter('th')->text()] = $node->filter('td')->eq(1)->text();
                            }

                        });
            } catch (Exception $ex) {

            }
                    
            //EMG_G1
            $typeCombine = array();
            try{
                $crawler->filter('#produit-tableau-EMP_G1 tr')
                        ->each(function (Crawler $node, $i) use (&$typeCombine) {
                            if($i > 0){
                                $typeCombine[$node->filter('th')->text()] = $node->filter('td')->text();
                            }

                        });
            } catch (Exception $ex) {

            }
                    
            //POP_T0
            $ageCombine = array();
            try{
                $crawler->filter('#produit-tableau-POP_T0 tr')
                        ->each(function (Crawler $node, $i) use (&$ageCombine) {
                            if($i > 1){
                                $ageCombine[$node->filter('th')->text()] = $node->filter('td')->eq(1)->text();
                            }
                        });
            } catch (Exception $ex) {

            }
                    
            $indicatorsRef = ['POP_T1'=>$popCombine, 'LOG_T3'=>$piecesCombine, 'EMP_G1'=>$typeCombine, 'POP_T0'=>$ageCombine];    
            //boucle sur la liste d'indicateurs
            foreach($indicators as $indicator){
                $indic = null;
                //boucle sur les indicateurs existantq de la ville
                foreach($city->getIndicatorValues() as $cityIndic){
                    if($cityIndic->getIndicator()->getCode() == $indicator->getCode()){
                        $indic = $cityIndic;
                        break;
                    }
                }
                //si l'indicateur n'existe pas pour la ville
                if($indic === null){
                    $indic = new IndicatorValue();
                    $indic->setCity($city);
                    $indic->setIndicator($indicator);
                    $em->persist($indic);
                }
                $indic->setTabData($indicatorsRef[$indicator->getCode()]);
            }
            
            if($city->getPrice() == null){
                $price = new Prices();
                $price->setCity($city);
            }
            else{
                $price = $city->getPrice();
            }
            
            $price->setPriceMeter($priceMeter);
            
            if($price->getId() == null){
                $em->persist($price);
            }
            
            //recupérer la popoulation avec l'url suivante:
            //https://geo.api.gouv.fr/communes/33063?fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=geojson&geometry=centre
            $urlGeoGouv = $this->container->getParameter("url_api_geo_gouv").$city->getInseeCode().$this->container->getParameter("url_api_geo_gouv_second");
            
            $data = $this->curl($urlGeoGouv);
            if(isset($data['properties']['population'])){
                //si la ville n'a pas de population en bdd
                if($city->getPopulation() == null){
                    $population = new Population();
                    $population->setCity($city);
                    $em->persist($population);
                }
                else{
                    $population = $city->getPopulation();
                }
                $population->setTotal($data['properties']['population']);
                
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        
        try{
            $em->flush();
            $io->success('Fin de la commande');
        } catch (\Exception $ex) {
            $io->error($ex->getMessage());
        }        
    }
    
    private function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        $data = json_decode($result,true);
        
        return $data;
    }
    
    private function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
    
    private function getCitiesRepository(){
        return $this->container->get('doctrine')->getRepository(Cities::class);
    }
    
    private function getIndicatorRepository(){
        return $this->container->get('doctrine')->getRepository(Indicator::class);
    }
}
