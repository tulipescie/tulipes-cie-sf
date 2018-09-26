<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Bulbe\ProjectBulbe;
use AppBundle\Entity\Project;
use Cocur\Slugify\Slugify;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class ProjectBulbeCreateListener implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'postUpdate',
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->setIsDispInProject($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->setIsDispInProject($args);
    }

    public function setIsDispInProject(LifecycleEventArgs $args)
    {
        $projectBulbe = $args->getObject();

        if (!$projectBulbe instanceof ProjectBulbe) {
            return;
        }

        $isDisp = $projectBulbe->isDispInProject();

        $project = $projectBulbe->getBulbeProject();
        if ($project) {
            $project->setIsNotShow(!$isDisp);
            $args->getObjectManager()->flush();
        }
    }

}