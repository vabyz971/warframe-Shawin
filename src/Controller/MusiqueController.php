<?php

namespace App\Controller;

use App\Entity\Musique;
use App\Repository\MusiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class MusiqueController extends AbstractController
{
    /**
     * @var MusiqueRepository
     */
    private $repository;

    public function __construct(MusiqueRepository $repository){

        $this->repository = $repository;
    }


    /**
     * @Route("/musique", name="musique")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Musique::class);

        $musiques = $repo->findAll();

        return $this->render('musique/index.html.twig',[
            'current_menu' => 'musiques',
            'musiques' => $musiques
        ]);
    }
}
