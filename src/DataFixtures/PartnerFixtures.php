<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PartnerFixtures extends Fixture
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
        $adminPartner = new Partner();
        $adminPartner->setUsername('BileMo');
        $adminPartner->setEmail('toto@gmail.com');
        $adminPartner->setPassword($this->userPasswordEncoder->encodePassword(
            $adminPartner,
            'admin'
        ));
        $adminPartner->setRoles(array('ROLE_USER'));

        $manager->persist($adminPartner);

        $manager->flush();
    }
}
