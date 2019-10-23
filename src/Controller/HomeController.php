<?php

namespace App\Controller;

use App\Repository\MusiqueRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{



    /**
     * @Route("/", name="home")
     * @param MusiqueRepository $repository
     */
    public function index(MusiqueRepository $repoMusique, UserRepository $repoUser)
    {
        //Affiche les musique les plus récents
        $musiques_recent = $repoMusique->findBy([], ['created' => 'DESC']);

        //Affiche les musique les plus aimer

        //Afficher les utilisateurs ou leur musique sont les plus comsulter
        $users_best = $repoUser->findAll(); // Affiche tout les utilisateurs



        return $this->render('home/index.html.twig', [
            'current_menu' => 'home',
            'musiques' => $musiques_recent,
            'users' => $users_best

        ]);
    }
}
