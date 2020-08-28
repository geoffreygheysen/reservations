<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixtures extends Fixture
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
                'firstname'=>'geo',
                'lastname'=>'fino',
                'email'=>'geo@fino.com',
                'langue'=>'fr',
            ],
            [
                'login'=>'johnny',
                'password'=>'testtest',
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
            $utilisateur->setFirstname($record['firstname']);
            $utilisateur->setLastname($record['lastname']);
            $utilisateur->setEmail($record['email']);
            $utilisateur->setLangue($record['langue']);
            
            $manager->persist($utilisateur);
            
            $this->addReference($record['login'], $utilisateur);
        }
        
        $manager->flush();
    }

}
