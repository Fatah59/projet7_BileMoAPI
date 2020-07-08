<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $customer1 = (new Customer())
            ->setFirstname('Jean')
            ->setLastname('DUPONT')
            ->setEmail('jeand@gmail.com');

        $manager->persist($customer1);

        $customer2 = (new Customer())
            ->setFirstname('Christelle')
            ->setLastname('DURANT')
            ->setEmail('christelled@gmail.com');

        $manager->persist($customer2);

        $customer3 = (new Customer())
            ->setFirstname('Alain')
            ->setLastname('DUPUIS')
            ->setEmail('alaind@gmail.com');

        $manager->persist($customer3);

        $customer4 = (new Customer())
            ->setFirstname('Claire')
            ->setLastname('SMITH')
            ->setEmail('clairesmith@gmail.com');

        $manager->persist($customer4);

        $manager->flush();
    }
}
