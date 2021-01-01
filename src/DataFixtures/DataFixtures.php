<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Partner;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DataFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // Create a partner //
        $adminPartner1 = new Partner();
        $adminPartner1->setUsername('BileMo');
        $adminPartner1->setEmail('toto@gmail.com');
        $adminPartner1->setPassword($this->userPasswordEncoder->encodePassword(
            $adminPartner1,
            'admin'
        ));
        $adminPartner1->setRoles(array('ROLE_USER'));

        $manager->persist($adminPartner1);

        // Create customers for the partner //
        for ($i = 0; $i<10; ++$i){
            $customer1 = (new Customer())
                ->setFirstname('Firstname'. $i)
                ->setLastname('Lastname'. $i)
                ->setEmail('customer' .$i.'@gmail.com')
                ->setPartner($adminPartner1);

            $manager->persist($customer1);
        }

        // Create the product list //
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

        $product5 =( new Product())
            ->setName('Iphone7')
            ->setBrand('Apple')
            ->setDescription('4G et 16Go')
            ->setPrice('50');

        $manager->persist($product5);

        $product6 =( new Product())
            ->setName('Iphone7')
            ->setBrand('Apple')
            ->setDescription('4G et 32Go')
            ->setPrice('40');

        $manager->persist($product6);

        $product7 =( new Product())
            ->setName('Iphone7')
            ->setBrand('Apple')
            ->setDescription('4G et 64Go')
            ->setPrice('60');

        $manager->persist($product7);

        $product8 =( new Product())
            ->setName('Iphone7')
            ->setBrand('Apple')
            ->setDescription('4G et 128Go')
            ->setPrice('100');

        $manager->persist($product8);

        // Create a partner2 //
        $adminPartner2 = new Partner();
        $adminPartner2->setUsername('SFR');
        $adminPartner2->setEmail('test2@gmail.com');
        $adminPartner2->setPassword($this->userPasswordEncoder->encodePassword(
            $adminPartner2,
            'admin'
        ));
        $adminPartner2->setRoles(array('ROLE_USER'));

        $manager->persist($adminPartner2);

        // Create customers for the partner2 //
        for ($i = 0; $i<10; ++$i){
            $customer1 = (new Customer())
                ->setFirstname('Firstname'. $i)
                ->setLastname('Lastname'. $i)
                ->setEmail('customer' .$i.'@gmail.com')
                ->setPartner($adminPartner2);

            $manager->persist($customer1);
        }
        $manager->flush();
    }
}
