<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Main\Cities;
use Symfony\Component\Console\Helper\ProgressBar;
use App\Entity\Main\Population;

class RecoverPopulationCommand extends Command
{
    protected static $defaultName = 'app:recover-population';

    private $container;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        parent::__construct();
    }
    
    protected function configure()
    {
        $this
            ->setDescription("Commande de récupération les données sur la population")
            ->addArgument('depCode', InputArgument::OPTIONAL, 'Code du département')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
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
        
        $progressBar = new ProgressBar($output, count($cities));
        $progressBar->start();
        
        $em = $this->container->get('doctrine')->getManager();
        
        foreach($cities as $city){
            $progressBar->advance();
            
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
        }
        $progressBar->finish();
        
        try{
            $em->flush();
            $io->success('Fin de la commande');
        } catch (\Exception $ex) {
            $io->error($ex->getMessage());
        } 
        
        return 0;
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
