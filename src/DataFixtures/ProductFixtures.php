<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public const NB_PRODUCTS = 20;
    public function load(ObjectManager $manager): void
    {
        for($i =0 ; $i<self::NB_PRODUCTS; $i++){
        $entity = new Product();
        $entity
            ->setName("Products $i")
            ->setPrice(mt_rand(1, 999))
            ->setDescription("Description produt $i")
            ->setQuantity(mt_rand(1, 10))
            ->setImage('image.jpg');

        $manager->persist($entity);
    }
        $manager->flush();
    }

}
