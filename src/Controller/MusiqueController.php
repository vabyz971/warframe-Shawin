<?php

namespace App\Controller;

use App\Entity\Musique;
use App\Repository\MusiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;


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
     * @Route("/musique/new", name="musique_created")
     */
    public function create(Request $request, ObjectManager $manager){

        $musique = new Musique();

        //Creation d'un formulaire
        $form = $this->createFormBuilder($musique)
            ->add('title')
            ->add('description')
            ->add('code')
            ->getForm();

        //Traitement du formulaire
        $form->handleRequest($request);

        //Si le form a des information
        if($form->isSubmitted() && $form->isValid()){
            $musique->setCreated(new \DateTime());

            $manager->persist($musique);     // Persister les donnés
            $manager->flush();              //Envoie des donnée

            //Redirection vaire la musique Ajouter
            return $this->redirectToRoute('musique_detail', ['id' => $musique->getId()]);
        }

        return $this->render("musique/create.html.twig",[
            'current_menu' => 'musique_new',
            'formMusique' => $form->createView()
        ]);
    }

    /**
     * @Route("/musique/{id}", name="musique_detail")
     */
    public function details(Musique $musiques){
        return $this->render("musique/detail.html.twig",[
            "musique" => $musiques
        ]);
    }
}
