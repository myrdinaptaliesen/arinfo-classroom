<?php

namespace App\Controller;

use App\Entity\Chapters;
use App\Form\ChaptersType;
use App\Repository\ChaptersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/chapters')]
class ChaptersController extends AbstractController
{
    #[Route('/', name: 'chapters_index', methods: ['GET'])]
    public function index(ChaptersRepository $chaptersRepository): Response
    {
        return $this->render('chapters/index.html.twig', [
            'chapters' => $chaptersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'chapters_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $chapter = new Chapters();
        $form = $this->createForm(ChaptersType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureChapter = $form->get('pictureChapter')->getData();
            if ($pictureChapter) {
                $originalFilename = pathinfo(
                    $pictureChapter->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureChapter->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $pictureChapter->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'photoEleve' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $chapter->setPictureChapter($newFilename);
            }
            $entityManager->persist($chapter);
            $entityManager->flush();

            return $this->redirectToRoute('chapters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chapters/new.html.twig', [
            'chapter' => $chapter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'chapters_show', methods: ['GET'])]
    public function show(Chapters $chapter): Response
    {
        return $this->render('chapters/show.html.twig', [
            'chapter' => $chapter,
        ]);
    }

    #[Route('/{id}/edit', name: 'chapters_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chapters $chapter, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ChaptersType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pictureChapter = $form->get('pictureChapter')->getData();
            if ($pictureChapter) {
                $originalFilename = pathinfo(
                    $pictureChapter->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureChapter->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $pictureChapter->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'photoEleve' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $chapter->setPictureChapter($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('chapters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chapters/edit.html.twig', [
            'chapter' => $chapter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'chapters_delete', methods: ['POST'])]
    public function delete(Request $request, Chapters $chapter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $chapter->getId(), $request->request->get('_token'))) {
            $entityManager->remove($chapter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chapters_index', [], Response::HTTP_SEE_OTHER);
    }
}
