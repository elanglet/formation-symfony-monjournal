<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    // Le nom de la route (page_accueil) servira de référence pour créer des liens vers cette page
    #[Route('/', name: 'page_accueil')]
    public function index(): Response
    {
        /*
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
        */

        // On délègue la requête vers l'action 'afficherTous' du 'ArticleController'
        return $this->forward('App\Controller\ArticleController::afficherTous');
    }
}
