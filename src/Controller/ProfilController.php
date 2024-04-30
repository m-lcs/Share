<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\FichierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(FichierRepository $fichierRepository): Response
    {
        $user = $this->getUser();

        $prenom = $user->getPrenom();
        $nom = $user->getNom();
        $email = $user->getEmail();
        $dateInscription = $user->getDateInscription()->format('Y-m-d H:i:s');

        $fichiers = $fichierRepository->findBy(['user' => $user]);
        $nombreFichiers = count($fichiers);

        return $this->render('profil/index.html.twig', [
            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $email,
            'dateInscription' => $dateInscription,
            'nombreFichiers' => $nombreFichiers,
            'fichiers' => $fichiers
        ]);
    }
}
