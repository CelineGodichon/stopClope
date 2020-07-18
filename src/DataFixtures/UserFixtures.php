<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('celine.godichon@hotmail.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $this->passwordEncoder->encodePassword($user, 'celine');
        $user->setPassword($password);
        $manager->persist($user);


        $manager->flush();
    }
}
