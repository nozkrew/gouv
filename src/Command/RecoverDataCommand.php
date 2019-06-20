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
        
        // creates a new progress bar (50 units)
        $progressBar = new ProgressBar($output, count($cities));

        // starts and displays the progress bar
        $progressBar->start();
        
        $em = $this->container->get('doctrine')->getManager();
        
        foreach($cities as $city){
            $url = $this->container->getParameter("url_base").str_replace(" ", "-", $city->getSlug())."-".$city->getZipCode().$this->container->getParameter("url_second").$city->getInseeCode();
            
            $data = $this->curl($url);
            
            $apartSale = null;
            $apartRent = null;
            $houseSale = null;
            $houseRent = null;
            
            //vente maison
            if(isset($data['data'][1])){
                $houseSale = $data['data'][1][4];
                //retire le signe euros
                $houseSale = str_replace(chr(0xE2).chr(0x82).chr(0xAC),"",$houseSale);
                //retir les espace
                $houseSale = str_replace(" ", "", $houseSale);
                //converti en int
                $houseSale = (int) $houseSale;
            }
            
            //vente appartement
            if(isset($data['data'][2])){
                $apartSale = $data['data'][2][4];
                //retire le signe euros
                $apartSale = str_replace(chr(0xE2).chr(0x82).chr(0xAC),"",$apartSale);
                //retir les espace
                $apartSale = str_replace(" ", "", $apartSale);
                //converti en int
                $apartSale = (int) $apartSale;
            }
            
            //location maison
            if(isset($data['data'][3])){
                $houseRent = $data['data'][3][4];
                //retire le signe €
                $houseRent = str_replace(chr(0xE2).chr(0x82).chr(0xAC),"",$houseRent);
                // supprime les espaces 
                $houseRent = str_replace(" ", "", $houseRent);
                //supprimer le /
                $houseRent = str_replace("/", "", $houseRent);
                //Supprime le "mois"
                $houseRent = str_replace("mois", "", $houseRent);
                //passage en int
                $houseRent = (int) $houseRent;
            }
            
            //location appartement
            if(isset($data['data'][4])){
                $apartRent = $data['data'][4][4];
                //retire le signe €
                $apartRent = str_replace(chr(0xE2).chr(0x82).chr(0xAC),"",$apartRent);
                // supprime les espaces 
                $apartRent = str_replace(" ", "", $apartRent);
                //supprimer le /
                $apartRent = str_replace("/", "", $apartRent);
                //Supprime le "mois"
                $apartRent = str_replace("mois", "", $apartRent);
                //passage en int
                $apartRent = (int) $apartRent;
            }
            
            //verifie qu'il y est au moins 1 des 4 valeurs non null
            if($apartSale !== null || $apartRent !== null || $houseSale !== null || $houseRent !== null){
                
                if($city->getPrice() == null){
                    $price = new Prices();
                    $price->setCity($city);
                }
                else{
                    $price = $city->getPrice();
                }

                $price->setApartmentSale($apartSale);
                $price->setApartmentRental($apartRent);
                $price->setHouseSale($houseSale);
                $price->setHouseRental($houseRent);

                if($price->getId() == null){
                    $em->persist($price);
                }
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
    
    private function getCitiesRepository(){
        return $this->container->get('doctrine')->getRepository(Cities::class);
    }
}
