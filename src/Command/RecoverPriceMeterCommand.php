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
use Goutte\Client;
use Symfony\Component\Console\Helper\ProgressBar;
use App\Entity\Prices;

class RecoverPriceMeterCommand extends Command
{
    protected static $defaultName = 'app:recover-price-meter';

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
        
        $client = new Client();
        
        $em = $this->container->get('doctrine')->getManager();
        
        foreach($cities as $city){
            $progressBar->advance();
            
            //Gestion du prix au m²
            $priceMeter = null;
            $crawler = $client->request('GET', 'https://www.rendementlocatif.com/investissement/villes/'.$city->getName().'/'.$city->getZipCode());
            $crawler->filter('.report_sub_block .value')->each(function ($node) use (&$priceMeter) {
                if(strpos($node->text(), "/m2") !== false){
                    $priceMeter = str_replace("€ /m2", "", $node->text());
                    $priceMeter = str_replace(" ", "", $priceMeter);
                }
            });
            
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
    
    private function getCitiesRepository(){
        return $this->container->get('doctrine')->getRepository(Cities::class);
    }
}
