<?php

namespace App\Controller;

use App\Repository\ThemesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ThemesRepository $themesRepository): Response
    {
        return $this->render('main/home.html.twig', [
            'themes' => $themesRepository->findAll(),
        ]);
    }
}
