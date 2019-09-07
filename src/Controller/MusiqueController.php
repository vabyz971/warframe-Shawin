<?php

namespace App\Controller;

use App\Entity\Musique;
use App\Repository\MusiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class MusiqueController extends AbstractController
{

    /**
     * @Route("/musique", name="musique")
     */
    public function index(MusiqueRepository $repo)
    {
        $musiques = $repo->findAll();

        return $this->render('musique/index.html.twig',[
            'current_menu' => 'musiques',
            'musiques' => $musiques
        ]);
    }


    /**
     * @Route("/musique/{id}", name="musique_detail")
     */
    public function details(MusiqueRepository $repo,$id)
    {
        $musiques = $repo->find($id);

        return $this->render("musique/detail.html.twig",[
            "musique" => $musiques
        ]);
    }
}
