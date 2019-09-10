<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Musique;
use App\Repository\MusiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

        return $this->render('musique/index.html.twig', [
            'current_menu' => 'musiques',
            'musiques' => $musiques
        ]);
    }


    /**
     * @Route("/musique/new", name="musique_created")
     * @Route("/musique/{id}/edit", name="musique_edit")
     */
    public function create(Musique $musique = null, Request $request, ObjectManager $manager)
    {

        if (!$musique)
            $musique = new Musique();

        //Création d'un formulaire
        $form = $this->createFormBuilder($musique)
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description')
            ->add('difficulty', ChoiceType::class, ['label' => 'Difficulté', 'choices' =>
                [
                    'Extrême' => 'Extreme',
                    'Dur' => 'Hard',
                    'Intermédiaire' => 'Intermediate',
                    'Facile' => 'Easy',
                    'Très Facile' => 'Very Easy',
                ],
            ])
            ->add('code')
            ->getForm();

        //Traitement du formulaire
        $form->handleRequest($request);

        //Si le form a des informations
        if ($form->isSubmitted() && $form->isValid()) {

            if (!$musique->getId())
                $musique->setCreated(new \DateTime());

            $manager->persist($musique);     // Persister les données
            $manager->flush();              //Envoie des données

            //Redirection vers la musique Ajouter
            return $this->redirectToRoute('musique_detail', ['id' => $musique->getId()]);
        }

        return $this->render("musique/create.html.twig", [
            'current_menu' => 'musique_new',
            'formMusique' => $form->createView(),
            'editMode' => $musique->getId() !== null
        ]);
    }

    /**
     * @Route("/musique/{id}", name="musique_detail")
     */
    public function details(Musique $musiques)
    {
        return $this->render("musique/detail.html.twig", [
            "musique" => $musiques
        ]);
    }
}
