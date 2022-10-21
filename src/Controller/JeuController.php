<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuController extends AbstractController
{
    #[Route('/jeu', name: 'app_jeu')]
    public function index(): Response
    {
        return $this->render('jeu/index.html.twig');
    }
}
