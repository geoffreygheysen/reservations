<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;
use App\DataFixtures\RoleFixtures;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'login'=>'geo',
                'password'=>'123',
                'role'=>'admin',
                'firstname'=>'geo',
                'lastname'=>'gheysen',
                'email'=>'geo@gheysen.com',
                'langue'=>'fr',
            ],
            [
                'login'=>'bob',
                'password'=>'123',
                'role'=>'member',
                'firstname'=>'bob',
                'lastname'=>'sull',
                'email'=>'bob@sull.com',
                'langue'=>'fr',
            ],
        ];
        
        foreach($users as $record) {
            $user = new User();
            $user->setLogin($record['login']);

            $user->setPassword(password_hash($record['password'], PASSWORD_BCRYPT));

            $user->setRole($this->getReference($record['role']));

            $user->setFirstname($record['firstname']);
            $user->setLastname($record['lastname']);
            $user->setEmail($record['email']);
            $user->setLangue($record['langue']);
            
            $manager->persist($user);
            
        }
        
        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            RoleFixtures::class,
        ];
        
    }

}
