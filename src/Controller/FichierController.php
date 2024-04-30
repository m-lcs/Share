<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FichierType;
use App\Entity\Fichier;
use App\Repository\UserRepository;
use App\Repository\ScategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Repository\FichierRepository;

class FichierController extends AbstractController
{
    #[Route('/ajout-fichiers', name: 'app_ajout_fichiers')]
    public function ajoutFichier(
        Request $request,
        ScategorieRepository $scategorieRepository,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
        $fichier = new Fichier();
        $scategories = $scategorieRepository->findBy([], ['categorie' => 'asc', 'numero' => 'asc']);
        $form = $this->createForm(FichierType::class, $fichier, ['scategories' => $scategories]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedScategories = $form->get('scategories')->getData();
            foreach ($selectedScategories as $scategorie) {
                $fichier->addScategory($scategorie);
            }
            $file = $form->get('fichier')->getData();

            if ($file) {
                $nomFichierServeur = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $nomFichierServeur = $slugger->slug($nomFichierServeur);
                $nomFichierServeur = $nomFichierServeur . '-' . uniqid() . '.' . $file->guessExtension();
                try {
                    $fichier->setNomServeur($nomFichierServeur);
                    $fichier->setNomOriginal($file->getClientOriginalName());
                    $fichier->setDateEnvoi(new \Datetime());
                    $fichier->setExtension($file->guessExtension());
                    $fichier->setTaille($file->getSize());
                    $em->persist($fichier);
                    $em->flush();
                    $file->move($this->getParameter('file_directory'), $nomFichierServeur);
                    $this->addFlash('notice', 'Fichier envoyé');
                    return $this->redirectToRoute('app_ajout_fichiers');
                } catch (FileException $e) {
                    $this->addFlash('notice', 'Erreur d\'envoi');
                }
            }
        }
        return $this->render('fichier/index.html.twig', [
            'form' => $form,
            'scategories' => $scategories
        ]);
    }

    #[Route('/liste-fichiers', name: 'app_liste_fichiers')]
    public function listeFichiers(FichierRepository $fichierRepository): Response
    {
        $fichiers = $fichierRepository->findAll();

        return $this->render('fichier/liste_fichiers.html.twig', [
            'fichiers' => $fichiers,
        ]);
    }

    #[Route('/liste-fichiers-par-utilisateur', name: 'app_liste_fichiers_par_utilisateur')]
    public function listeFichiersParUtilisateur(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ['nom' => 'asc', 'prenom' => 'asc']);
        return $this->render('fichier/liste-fichiers-par-utilisateur.html.twig', ['users' => $users]);
    }
}
