<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Project;
use Cocur\Slugify\Slugify;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ProjectCreateListener implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return array('prePersist');
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->index($args);

    }

    public function index(LifecycleEventArgs $args)
    {
        $project = $args->getObject();

        if (!$project instanceof Project) {
            return;
        }

        $slugify = new Slugify();

        $slugify->addRule('<br>', '-');
        $slug = $slugify->slugify($project->getTitle());

        $projects = $args->getObjectManager()
            ->getRepository(Project::class)
            ->createQueryBuilder('p')
            ->where('p.slug LIKE :slug')
            ->setParameter('slug', '%'.$slug)
            ->getQuery()->getResult();

        if (count($projects) > 0) {
            $slug .= '_'.count($projects);
        }

        $project->setSlug($slug);

    }
}