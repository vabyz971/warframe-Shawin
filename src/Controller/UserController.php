<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    /**
     * @Route("/user_setting", name="user_setting")
     */
    public function setting_user(UserRepository $repo)
    {

        $user = $repo->findAll();

        return $this->render('user/setting.html.twig', [
            'controller_name' => 'UserController',
            'user_infos' => $user
        ]);
    }
}
