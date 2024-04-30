<?php
namespace App\EventListener;

use App\Entity\Scategorie;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class ScategorieListener
{
    public function prePersist(Scategorie $scategorie, LifecycleEventArgs $event): void
    {
        $entityManager = $event->getObjectManager();
        $repository = $entityManager->getRepository(Scategorie::class);
        $count = $repository->trouverDoublon($scategorie->getNumero(), $scategorie->getCategorie());
        if ($count > 0) {
            throw new \RuntimeException("Il existe déjà une sous-catégorie avec ce numéro");
        }
    }
}
