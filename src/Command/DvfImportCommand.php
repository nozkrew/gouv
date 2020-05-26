<?php

namespace App\Command;

use App\Entity\Dvf\Dvf;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


class DvfImportCommand extends Command
{
    protected static $defaultName = 'app:dvf-import';

    private $em;
    private $year;

    private $years = [2014,2015,2016,2017,2018,2019];

    public function __construct(ContainerInterface $container){
        $this->em = $container->get('doctrine')->getManager('dvf');
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription("Recupères les données DVF des ventes précèdentes")
            ->addArgument('year', InputArgument::REQUIRED, 'Année')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->year = $input->getArgument('year');

        //a supprimer
        try{
            $this->truncate();
        }
        catch(\Exception $e){
            dump($e);die;
        }
        //--------------------

        $file = "https://cadastre.data.gouv.fr/data/etalab-dvf/latest/csv/".$this->year."/full.csv.gz";

        //création du dossier
        if(!file_exists(__DIR__."/../../db/tmp")){
            mkdir(__DIR__."/../../db/tmp", 0700);
        }

        $filegz = __DIR__."/../../db/tmp/".$this->year."-full.csv.gz";

        //téléchargement du fichier zip
        file_put_contents($filegz, fopen($file, 'r'));

        //Dézip
        $buffer_size = 4096; // read 4kb at a time
        $out_file_name = str_replace('.gz', '', $filegz);
        $file = gzopen($filegz, 'rb');
        $out_file = fopen($out_file_name, 'wb');

        while (!gzeof($file)) {
            fwrite($out_file, gzread($file, $buffer_size));
        }
        // On ferme les fichiers
        fclose($out_file);
        gzclose($file);

        $counter = 0;
        $flag = true;
        $endRow = count(file($out_file_name)) - 1;

        $progressBar = new ProgressBar($output, $endRow);
        $progressBar->start();

        if (($handle = fopen($out_file_name, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if($flag) { $flag = false; continue; }

                $dvf = new Dvf();
                $dvf->setIdMutation($data[0]);
                $dvf->setDateMutation(new \DateTime($data[1]));
                $dvf->setNumeroDisposition($data[2]);
                $dvf->setNatureMutation($data[3]);
                $dvf->setValeurFonciere($data[4] === "" ? null : $data[4]);
                $dvf->setAdresseNumero((int) $data[5]);
                $dvf->setAdresseSuffixe($data[6]);
                $dvf->setAdresseNomVoie($data[7]);
                $dvf->setAdresseCodeVoie($data[8]);
                $dvf->setCodePostal($data[9]);
                $dvf->setCodeCommune($data[10]);
                $dvf->setNomCommune($data[11]);
                $dvf->setCodeDepartement($data[12]);
                $dvf->setAncienCodeCommune($data[13]);
                $dvf->setAncienNomCommune($data[14]);
                $dvf->setIdParcelle($data[15]);
                $dvf->setAncienIdParcelle($data[16]);
                $dvf->setNumeroVolume($data[17]);
                $dvf->setLot1Numero($data[18]);
                $dvf->setLot1SurfaceCarrez((float) $data[19]);
                $dvf->setLot2Numero($data[20]);
                $dvf->setLot2SurfaceCarrez((float) $data[21]);
                $dvf->setLot3Numero($data[22]);
                $dvf->setLot3SurfaceCarrez((float) $data[23]);
                $dvf->setLot4Numero($data[24]);
                $dvf->setLot4SurfaceCarrez((float) $data[25]);
                $dvf->setLot5Numero($data[26]);
                $dvf->setLot5SurfaceCarrez((float) $data[27]);
                $dvf->setNombreLots($data[28]);
                $dvf->setCodeTypeLocal($data[29]);
                $dvf->setTypeLocal($data[30]);
                $dvf->setSurfaceReelleBati((int) $data[31]);
                $dvf->setNombrePiecesPrincipales((int) $data[32]);
                $dvf->setCodeNatureCulture($data[33]);
                $dvf->setNatureCulture($data[34]);
                $dvf->setCodeNatureCultureSpeciale($data[35]);
                $dvf->setNatureCultureSpeciale($data[36]);
                $dvf->setSurfaceTerrain((float) $data[37]);
                $dvf->setLongitude((float) $data[38]);
                $dvf->setLatitude((float) $data[39]);
                try{
                    $this->em->persist($dvf);
                    $counter++;

                    //On enregistre tous les 10 ou si on est arrivé au dernier
                    if($counter % 100 == 0 || $endRow == $counter){
                        $this->em->flush();
                    }
                }
                catch(\Exception $ex){
                    $output->writeln("Erreur : ". $ex->getMessage());
                }
                $progressBar->advance();
            }
            $progressBar->finish();
            fclose($handle);
        }

        //TODO: supprimer le dossier tmp
        


        return 0;
    }

    private function truncate(){
        $classMetaData = $this->em->getClassMetadata(Dvf::class);
        $connection = $this->em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();
        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($classMetaData->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        }
        catch (\Exception $e) {
            $connection->rollback();
        } 
    }
}
