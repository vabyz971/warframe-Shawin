<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MusiqueController extends AbstractController
{
    /**
     * @Route("/musique", name="musique")
     */
    public function index()
    {
        return $this->render('musique/index.html.twig',[
            'current_menu' => 'musiques'
        ]);
    }
}
