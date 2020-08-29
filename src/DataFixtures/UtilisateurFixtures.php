<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
         $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $utilisateurs = [
            [
                'login'=>'geoffino',
                'password'=>'testtest',
                'role'=>'admin',
                'firstname'=>'geo',
                'lastname'=>'fino',
                'email'=>'geo@fino.com',
                'langue'=>'fr',
            ],
            [
                'login'=>'johnny',
                'password'=>'testtest',
                'role'=>'user',
                'firstname'=>'john',
                'lastname'=>'doe',
                'email'=>'john@doe.com',
                'langue'=>'fr',
            ],
        ];

        foreach($utilisateurs as $record) {
            $utilisateur = new utilisateur();

            $utilisateur->setLogin($record['login']);

            $utilisateur->setPassword($this->passwordEncoder->encodePassword($utilisateur,$record['password']));
            $utilisateur->setRole($this->getReference($record['role']));

            $utilisateur->setFirstname($record['firstname']);
            $utilisateur->setLastname($record['lastname']);
            $utilisateur->setEmail($record['email']);
            $utilisateur->setLangue($record['langue']);
            
            $manager->persist($utilisateur);
            
            $this->addReference($record['login'], $utilisateur);
        }
        
        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            RoleFixtures::class,
        ];
        
    }

}
