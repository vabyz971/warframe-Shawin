<?php

namespace App\Controller;

use App\Repository\MusiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{



    /**
     * @Route("/", name="home")
     * @param MusiqueRepository $repository
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }
}
