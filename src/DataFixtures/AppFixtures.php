<?php

namespace App\DataFixtures;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface ;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct (UserPasswordEncoderInterface $passwordEncoder)
    {
        $this ->passwordEncoder = $passwordEncoder;
    }
    public function load (ObjectManager $manager)
    {
        $user = new User();
        $user->setPassword( $this ->passwordEncoder->encodePassword(
            $user,
            '123456'
        ));
        $user->setEmail( "lisa@mail.com" );
        $manager->persist($user);
        $manager->flush();
    }
}
