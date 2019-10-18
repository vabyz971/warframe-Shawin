<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\MusiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("/user_setting", name="user_setting")
     */
    public function setting_user(UserRepository $repoU,MusiqueRepository $repoM,TokenStorageInterface $tokenStorage)
    {
        $curUser = $tokenStorage->getToken() ? $tokenStorage->getToken()->getUser() : null;
        $user = $repoU->findAll();
        $nbMusiques = $repoM->countMusiques($curUser->getId());
        $myMusics = $repoM->myMusics($curUser->getId());

        return $this->render('user/setting.html.twig', [
            'controller_name' => 'UserController',
            'user_infos' => $user,
            'nombreMusiques' => $nbMusiques,
             'myMusics' => $myMusics
        ]);
    }
}
