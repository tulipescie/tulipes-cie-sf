<?php

namespace AppBundle\Command;

use AppBundle\Entity\Filter\CustomerFilter;
use AppBundle\Entity\Media;
use AppBundle\Entity\Project;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

use Caramia\TranslationBundle\Entity\StringTranslatable;
use Caramia\TranslationBundle\Entity\TextTranslatable;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImportCommand
 * @package AppBundle\Command
 */
class ImportCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    private static $csvFileName = "data/contenus.csv";
    /**
     * @var string
     */
    private static $mediaPath = "data/images/";

    /**
     *
     */
    protected function configure()
	{
		// Name and description for app/console command
		$this
			->setName('import:csv')
			->setDescription('Import projects from CSV file');
	}

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
	{
		// Showing when the script is launched
		$now = new \DateTime();
		$output->writeln('<comment>--- Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');

		// Importing CSV on DB via Doctrine ORM
		$this->import($input, $output);

		// Showing when the script is over
		$now = new \DateTime();
		$output->writeln('<comment>--- End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
	}

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function import(InputInterface $input, OutputInterface $output)
	{
		// Getting php array of data from CSV
		$data = $this->getCSV();

		// Getting doctrine manager
		$em = $this->getContainer()->get('doctrine')->getManager();
		// Turning off doctrine default logs queries for saving memory
		$em->getConnection()->getConfiguration()->setSQLLogger(null);

		// Define the size of record, the frequency for persisting the data and the current index of records
		$size = count($data);
		$batchSize = 20;
		$i = 1;

		// Starting progress
		$progress = new ProgressBar($output, $size);
		$progress->start();

		// Processing on each row of data
		foreach($data as $row) {
            $project = new Project();

            $project->setTitle($row['title']);
            $project->setVideoUrl($row['video']);
            $project->setIsNotShow(false);

            if (empty($row['contexte'])) {
                $content = '<p></p>';
            } else {
                $content = '<h3 class="subtitle_1">Le contexte</h3>
                        <p>' . $row['contexte'] . '</p>
                        <h3 class="subtitle_1">La demande client</h3>
                        <p>' . $row['demande'] . '</p>
                        <h3 class="subtitle_1">Notre proposition</h3>
                        <p>' . $row['proposition'] . '</p>';
            }
            $project->getContent()->fr = $content;
            $project->getContent()->en = $content;
            $project->getContent()->es = $content;

            $onlineAt = new \DateTime();
            $onlineAt->format('d-m-Y G:i:s');
            $project->setOnlineAt($onlineAt);

            //Set Project Header's image and persist it
            $mediaHeader = $this->saveMedia($row['header']);
            $em->persist($mediaHeader);
            $project->setHeaderImage($mediaHeader);

            //Set 5 Project thumbs images and persist it
            for ($i=1 ; $i<=3 ; $i++) {
                if (!empty($row['miniature_'.$i])) {
                    ${"media".$i} = $this->saveMedia($row['miniature_'.$i]);
                    $em->persist(${"media".$i});
                    $fctSetThumb = "setThumb".$i."Image";
                    $project->$fctSetThumb(${"media".$i});
                }
            }

            $awards = (!empty($row['recompenses'])) ? "Oui" : "Non";
            $filters = [
                'Activity' => $row['secteurs'],
                'Thematic' => $row['thematiques'],
                'Award'    => $awards,
                'Tech'     => $row['formats'],
                'Customer' => $row['clients'],
                'Director' => $row['realisateur'],
            ];
            $this->setFiltersProject($project, $filters, $em);


            // Persisting the project
            $em->persist($project);

            // Each 20 users persisted we flush everything
            if (($i % $batchSize) === 0) {

                $em->flush();
                // Detaches all objects from Doctrine for memory save
                $em->clear();

                // Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of projects imported ... | ' . $now->format('d-m-Y G:i:s'));
            }

            $i++;

        }

        // Flushing and clear data on queue
        $em->flush();
        $em->clear();

        // Ending the progress bar process
        $progress->finish();
	}

    /**
     * Getting the CSV from filesystem
     *
     * @return array
     */
    protected function getCSV()
    {
        // Using service for converting CSV to PHP Array
        $converter = $this->getContainer()->get('import.csvtoarray');
        $data = $converter->convert(static::$csvFileName, ';');

        return $data;
    }

    /**
     * Save Media $nameMedia in Vich_uploader's directory
     *
     * @param string $nameMedia
     * @return Media
     */
    protected function saveMedia($nameMedia)
    {
        // Le path absolute de ton fichier
        $mediaFile = static::$mediaPath . $nameMedia;
        // On créé un fichire temporaire dans avec un nom automatique comme 'importCLI_a3ddfc' dans /tmp
        $tmpPath = tempnam(sys_get_temp_dir(), 'importCLI');
        // On copie le fichier original dans notre temp car l'upload supprime le fichier source
        copy($mediaFile, $tmpPath);

        $file = new UploadedFile(
            $tmpPath,
            basename($mediaFile),
            null,
            null,
            null,
            true // L'astuce est ici, on spécifie fichier "test" donc pas de verif qu'il est bien dans le $_FILE
        );

        $media = new Media();
        $media->setImageFile($file);

        return $media;
    }

    /**
     * @param Project $project
     * @param array $tabValues
     * @param EntityManager $em
     * @return $this
     */
    protected function setFiltersProject(Project $project, Array $tabValues, EntityManager $em)
    {
        foreach (Project::$filtersTypes as $filterKey => $filterClass) {
            $filter = $em->getRepository($filterClass)->findOneBy(array('name.fr' => $tabValues[$filterKey]));

            if(!empty($filter)){
                $project->setFiltersWithClass($filterClass, [$filter]);
            }
        }

        return $this;
	}

}