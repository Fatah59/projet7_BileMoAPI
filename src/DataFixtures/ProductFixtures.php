<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $product1 =( new Product())
            ->setName('A3')
            ->setBrand('Samsung')
            ->setDescription('4G et 16Go')
            ->setPrice('20');

        $manager->persist($product1);

        $product2 =( new Product())
            ->setName('A5')
            ->setBrand('Samsung')
            ->setDescription('4G et 32Go')
            ->setPrice('40');

        $manager->persist($product2);

        $product3 =( new Product())
            ->setName('A7')
            ->setBrand('Samsung')
            ->setDescription('4G et 64Go')
            ->setPrice('60');

        $manager->persist($product3);

        $product4 =( new Product())
            ->setName('S10')
            ->setBrand('Samsung')
            ->setDescription('4G et 128Go')
            ->setPrice('100');

        $manager->persist($product4);

        $manager->flush();
    }
}
