<?php

namespace App\Controller;

use App\Entity\Scategorie;
use App\Form\AjoutScategorieType;
use App\Form\ModifierScategorieType;
use App\Form\SupprimerScategorieType;
use App\Repository\ScategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScategorieController extends AbstractController
{
    #[Route('/private-liste-scategories', name: 'app_liste_scategories', methods: ['GET', 'POST'])]
    public function listeScategories(
        Request $request,
        ScategorieRepository $scategorieRepository,
        EntityManagerInterface $em
    ): Response {
        $scategories = $scategorieRepository->findAll();
        $form = $this->createForm(SupprimerScategorieType::class, null, [
            'scategories' => $scategories
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedScategories = $form->get('scategories')->getData();
            foreach ($selectedScategories as $scategorie) {
                $em->remove($scategorie);
            }
            $em->flush();
            $this->addFlash('notice', 'Sous-catégories supprimées avec succès');
            return $this->redirectToRoute('app_liste_scategories');
        }
        return $this->render('scategorie/liste.html.twig', [
            'scategories' => $scategories,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/private-modifier-scategorie/{id}', name: 'app_modifier_scategorie')]
    public function modifierScategorie(
        Request $request,
        Scategorie $scategorie,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(ModifierScategorieType::class, $scategorie);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($scategorie);
                $em->flush();
                $this->addFlash('notice', 'Sous-catégorie modifiée');
                return $this->redirectToRoute('app_liste_scategories');
            }
        }
        return $this->render('scategorie/modifier.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/private-supprimer-scategorie/{id}', name: 'app_supprimer_scategorie')]
    public function supprimerScategorie(
        Request $request,
        Scategorie $scategorie,
        EntityManagerInterface $em
    ): Response {
        if ($scategorie != null) {
            $em->remove($scategorie);
            $em->flush();
        }
        return $this->redirectToRoute('app_liste_scategories');
    }

    #[Route('/private-ajouter-scategorie', name: 'app_ajouter_scategorie')]
    public function ajouterScategorie(Request $request, EntityManagerInterface $em): Response
    {
        $scategorie = new Scategorie();
        $form = $this->createForm(AjoutScategorieType::class, $scategorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($scategorie);
            $em->flush();
            
            $this->addFlash('success', 'La sous-catégorie a été ajoutée avec succès.');
            
            return $this->redirectToRoute('app_liste_scategories');
        }

        return $this->render('scategorie/ajout-scategorie.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
