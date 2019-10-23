<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Musique;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\MusiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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
    public function create(Musique $musique = null, Request $request, ObjectManager $manager, TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;
        if (!$musique)
            $musique = new Musique();

        //Création d'un formulaire
        $form = $this->createFormBuilder($musique)
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('visual')
            ->add('code')
            ->getForm();

        //Traitement du formulaire
        $form->handleRequest($request);

        //Si le form a des informations
        if ($form->isSubmitted() && $form->isValid()) {

            if (!$musique->getId()) {
                $musique->setCreated(new \DateTime())
                    ->setIdUser($user);
            }

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

    public function details(Musique $musiques, Request $request, ObjectManager $manager, TokenStorageInterface $tokenStorage)
    {

        $user = $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setCreatedAt(new \DateTime())
                ->setMusique($musiques)
                ->setAuthor($user->getUsername())
                ->setUsers($user);

            $manager->persist($comment);
            $manager->flush();


            return $this->redirectToRoute('musique_detail', ['id' => $musiques->getId()]);
        }

        return $this->render("musique/detail.html.twig", [
            "musique" => $musiques,
            "commentForm" => $form->createView()
        ]);
    }

    /**
     * @Route("/musique/{id}/suppressionmusique", name="musique_suppression")
     * @param Musique $musique
     */
    public function supprimer_musique(Musique $musique, ObjectManager $manager, TokenStorageInterface $tokenStorage)
    {

        $user = $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;
        if ($user->getId() == $musique->getIdUser()->getId()) {
            foreach ($musique->getCommented() as $comment) {
                $manager->remove($comment);
            }
            $manager->remove($musique);
            $manager->flush();
        }
        return $this->redirectToRoute('musique');
    }
    /** 
     *@Route("/musique/{id}/suppressioncomment/{COM}", name="comment_suppression")
     */
    public function supprimer_comment(Int $COM, Musique $musique, ObjectManager $manager, TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;
        $comment = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->find($COM);
        if ($user->getId() == $comment->getUsers()->getId()) {
            $manager->remove($comment);
            $manager->flush();
        }
        return $this->redirectToRoute('musique_detail', ['id' => $musique->getId()]);
    }
}
