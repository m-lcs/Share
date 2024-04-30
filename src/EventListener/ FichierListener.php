<?php
namespace App\EventListener;

use App\Entity\Fichier;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class FichierListener
{
    public function prePersist(Fichier $fichier, LifecycleEventArgs $event): void
    {
        $fichier->setDateEnvoi(new \Datetime());

    }
}
