<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface; 
use App\Entity\Article;
use App\Form\ArticleType;

class ArticleController extends AbstractController
{
    // On ajoute le code permettant d'obtenir l'EntityManager et le Repository pour manipuler les entités
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    // Afficher tous les articles
    #[Route('/article/tous', name: 'article_tous')]
    public function afficherTous(): Response
    {
        $repository = $this->em->getRepository('App\Entity\Article');
        $listeDesArticles = $repository->findAll();

        // dump($listeDesArticles);

        return $this->render(
            'article/tous.html.twig', 
            [
                'les_articles' => $listeDesArticles,
            ]
        );
    }

    // Afficher un article via son id unique
    #[Route('/article/afficher/{id}', name: 'article_afficher')]
    public function afficherArticle($id): Response
    {
        // $id va permettre de sélectionner l'article dans la base de données

        // Récupérer un repository pour récupérer l'article à afficher
        $repository = $this->em->getRepository('App\Entity\Article'); // 'App\Entity\Article' fait référence à l'entité Article

        // Avec la méthode find() on récupère l'article par son id
        $article = $repository->find($id);

        /*
         * On peut regrouper ces 2 instructions en 1 seule 
         * 
         * $article = $this->em->getRepository('App\Entity\Article')->find($id);
         */ 

        // Avec la fonction dump() de Symfony, on affiche l'objet article récupéré dans le Profiler
        // en attendant de pouvoir l'afficher dans la vue.
        // dump($article);   
        
        return $this->render(
            'article/afficher.html.twig',    // 1. Le nom du template à utiliser              
            [                                // 2. Tableau de variables Twig à transmettre
                'article' => $article,       // On transmet la variable 'article' associée à l'objet Article ($article) obtenu de la base 
            ]
        );
    }



    // Créer un article
    #[Route('/article/creer', name: 'article_creer')]
    public function creerArticle(Request $request): Response
    {
        /**
         * Il faut penser à ajouter la directive 'use' suivante pour pouvoir utiliser 
         * la classe 'Article' :
         * 
         * use App\Entity\Article;
         * 
         */

        // 1. Créer une instance d'entité Article pour la valoriser avec le formulaire
        $article = new Article();

        // 2. On créé le formulaire ET on l'associe à l'entité
        $form = $this->createForm(
            ArticleType::class,         // La classe de formulaire. Attention au 'use App\Form\ArticleType;' !!!
            $article                    // L'instance de l'entité à associer au formulaire
        );

        // 3. Traitement de la requête : savoir si on souhaite afficher ou traiter le formulaire
        $form->handleRequest($request); // $request doit être déclaré en paramètre de l'action
                                        // Attention au 'use Symfony\Component\HttpFoundation\Request;' !!!    

        // 4. Décision :
        if($form->isSubmitted()) {
            // Le formulaire est soumis...
            // Enregistrer l'entité dans la base
            $this->em->persist($article);
            // Permet de valider les modifications dans la base de données.
            $this->em->flush();
            // Il faudra prévoir un affichage ...
        }
        else {
            // Le formulaire doit être affiché
            return $this->render(
                'article/creer.html.twig', 
                [
                    'articleForm' => $form->createView(),   // On transmet l'objet de formulaire au template de vue
                ]
            );
        }
    }





    // Modifier un article via son id unique
    #[Route('/article/modifier/{id}', name: 'article_modifier')]
    public function modifierArticle($id): Response
    {
        // 1. Récupérer l'article à modifier par son id dans la base
        $article = $this->em->getRepository('App\Entity\Article')->find($id);

        // 2. Mettre à jour les informations de l'article
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $article->setDate($date);

        // 3. Enregistrer les modifications avec persist() + flush()
        $this->em->persist($article);
        $this->em->flush();

        return $this->render(
            'article/modifier.html.twig', 
            [
                
            ]
        );
    }

    // Supprimer un article via son id unique
    #[Route('/article/supprimer/{id}', name: 'article_supprimer')]
    public function supprimerArticle($id): Response
    {
        // $id va permettre de sélectionner l'article dans la base de données
        $article = $this->em->getRepository('App\Entity\Article')->find($id);

        $this->em->remove($article);
        $this->em->flush();

        // On génère un message flash pour la suppression
        $this->addFlash(
           'notice',
           "Votre article à été supprimé."
        );

        /*
         A la place de l'affichage du template, on redirige vers la liste des articles.

        return $this->render('article/supprimer.html.twig', [
            'controller_name' => 'ArticleController',
        ]);

        
        Pour faire une redirection, on utilise la méthode redirect()

        */

        return $this->redirect(                       // On doit préciser vers quelle URL rediriger
            $this->generateUrl('article_tous')        // On construit l'URL à partir du nom de la route
        );

    }
}
