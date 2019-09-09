<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Musique;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MusiqueFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        // Création des utilisateurs
        for ($us = 1; $us < 5; $us++) {

            $users = new User();
            $users->setEmail($faker->email)
                ->setPassword($faker->sha256)
                ->setUsername($faker->name())
                ->setCreatedAt($faker->dateTimeBetween());

            $manager->persist($users);

            // Création des musiques
            for ($i = 1; $i < 3; $i++) {
                $musique = new Musique();
                $musique->setTitle($faker->sentence())
                    ->setDescription($faker->paragraph())
                    ->setCode($faker->iban())
                    ->setDifficulty($faker->randomLetter)
                    ->setVisual($faker->imageUrl())
                    ->setCreated($faker->dateTimeBetween())
                    ->setIdUser($users);


                $manager->persist($musique);

                // Ajouter des commentaires au musique
                for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                    $comment = new Comment();

                    $content = join($faker->paragraphs(2));

                    //$days = (new \DateTime())->diff($musique->getCreated())->days;

                    $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween())
                        ->setMusique($musique)
                        ->setUsers($users);

                    $manager->persist($comment);
                }
            }
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
