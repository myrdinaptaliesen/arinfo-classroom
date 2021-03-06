<?php

namespace App\Controller;

use App\Entity\Themes;
use App\Form\ThemesType;
use App\Repository\ThemesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/themes')]
class ThemesController extends AbstractController
{
    #[Route('/', name: 'themes_index', methods: ['GET'])]
    public function index(ThemesRepository $themesRepository): Response
    {
        return $this->render('themes/index.html.twig', [
            'themes' => $themesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'themes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $theme = new Themes();
        $form = $this->createForm(ThemesType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictureTheme = $form->get('pictureTheme')->getData();
            if ($pictureTheme) {
                $originalFilename = pathinfo(
                    $pictureTheme->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureTheme->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $pictureTheme->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'photoEleve' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $theme->setPictureTheme($newFilename);
            }




            $entityManager->persist($theme);
            $entityManager->flush();

            return $this->redirectToRoute('themes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('themes/new.html.twig', [
            'theme' => $theme,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'themes_show', methods: ['GET'])]
    public function show(Themes $theme): Response
    {
        return $this->render('themes/show.html.twig', [
            'theme' => $theme,
        ]);
    }

    #[Route('/{slug}/edit', name: 'themes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Themes $theme, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ThemesType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictureTheme = $form->get('pictureTheme')->getData();
            if ($pictureTheme) {
                $originalFilename = pathinfo(
                    $pictureTheme->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureTheme->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $pictureTheme->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'photoEleve' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $theme->setPictureTheme($newFilename);
            }


            $entityManager->flush();

            return $this->redirectToRoute('themes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('themes/edit.html.twig', [
            'theme' => $theme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'themes_delete', methods: ['POST'])]
    public function delete(Request $request, Themes $theme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $theme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($theme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('themes_index', [], Response::HTTP_SEE_OTHER);
    }
}
