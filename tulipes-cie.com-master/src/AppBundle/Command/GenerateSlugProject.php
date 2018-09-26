<?php

namespace AppBundle\Command;


use AppBundle\Entity\Project;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSlugProject extends ContainerAwareCommand
{

    protected function configure()
    {
        // Name and description for app/console command
        $this
            ->setName('generate:project:slug')
            ->setDescription("Generate a slug on projects who doesn't have one.");
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
        $this->addSlug($input, $output);

        // Showing when the script is over
        $now = new \DateTime();
        $output->writeln('<comment>--- End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function addSlug(InputInterface $input, OutputInterface $output)
    {

        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        // Get all projects haven't a slug
        $projects = $em->getRepository(Project::class)
            ->createQueryBuilder('p')
            ->where('p.slug = :slug')
            ->setParameter('slug', '')
            ->getQuery()->getResult();

        $size = count($projects);

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        // Processing on each row of data
        foreach($projects as $key=>$project) {

            $slugify = new Slugify();

            $slugify->addRule('<br>', '-');
            $slug = $slugify->slugify($project->getTitle());

            $projectsWithSlug = $em->getRepository(Project::class)
                ->createQueryBuilder('p')
                ->where('p.slug LIKE :slug')
                ->setParameter('slug', '%'.$slug)
                ->getQuery()->getResult();

            if (count($projectsWithSlug) > 0) {
                $slug .= '_'.count($projectsWithSlug);
            }

            $project->setSlug($slug);

            // Detaches all objects from Doctrine for memory save
            $em->flush();

            // Advancing for progress display on console
            $progress->advance();
            $output->writeln(' ' . ($key+1).' project sulg generate.');

        }

        // Flushing and clear data on queue
        $em->flush();
        $em->clear();

        // Ending the progress bar process
        $progress->finish();
    }
}