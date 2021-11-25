<?php

namespace App\Controller;

use App\Entity\SubChapters;
use App\Form\SubChaptersType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubChaptersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/sub/chapters')]
class SubChaptersController extends AbstractController
{
    #[Route('/', name: 'sub_chapters_index', methods: ['GET'])]
    public function index(SubChaptersRepository $subChaptersRepository): Response
    {
        return $this->render('sub_chapters/index.html.twig', [
            'sub_chapters' => $subChaptersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'sub_chapters_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $subChapter = new SubChapters();
        $form = $this->createForm(SubChaptersType::class, $subChapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $videoSubChapter = $form->get('videoSubChapter')->getData();
            if ($videoSubChapter) {
                $originalFilename = pathinfo(
                    $videoSubChapter->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                // ceci est nécessaire pour inclure en toute sécurité le nom de fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $videoSubChapter->guessExtension();
                // Déplacez le fichier dans le répertoire où les brochures sont stockées
                try {
                    $videoSubChapter->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                    // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
                }
                // met à jour la propriété 'photoEleve' pour stocker le nom du fichier PDF
                // au lieu de son contenu
                $subChapter->setVideoSubChapter($newFilename);
            }
            $entityManager->persist($subChapter);
            $entityManager->flush();

            return $this->redirectToRoute('sub_chapters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sub_chapters/new.html.twig', [
            'sub_chapter' => $subChapter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'sub_chapters_show', methods: ['GET'])]
    public function show(SubChapters $subChapter): Response
    {
        return $this->render('sub_chapters/show.html.twig', [
            'sub_chapter' => $subChapter,
        ]);
    }

    #[Route('/{id}/edit', name: 'sub_chapters_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubChapters $subChapter, EntityManagerInterface $entityManager,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(SubChaptersType::class, $subChapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('sub_chapters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sub_chapters/edit.html.twig', [
            'sub_chapter' => $subChapter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'sub_chapters_delete', methods: ['POST'])]
    public function delete(Request $request, SubChapters $subChapter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subChapter->getId(), $request->request->get('_token'))) {
            $entityManager->remove($subChapter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sub_chapters_index', [], Response::HTTP_SEE_OTHER);
    }
}
