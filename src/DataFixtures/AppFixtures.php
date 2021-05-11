<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use App\Entity\Categorie;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
           $categorie = Array();
           for ($i = 0; $i < 2; $i++) {
               $categorie[$i] = new Categorie();
               $categorie[$i]->setNom($faker->lastName);
               $categorie[$i]->setDescription($faker->firstName);
			   $categorie[$i]->setPhoto($faker->firstName);
               $manager->persist($categorie[$i]);
           }
        $manager->flush();
    }
}
