<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Artist;

class ArtistFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $artists =[
            [
                'firstname'=>'Daniel',
                'lastname'=>'Marcelin'
            ],
            [
                'firstname'=>'Philippe',
                'lastname'=>'Laurent'
            ],
            [
                'firstname'=>'Marius',
                'lastname'=>'Von Mayenburg'
            ],
            [
                'firstname'=>'Olivier',
                'lastname'=>'Boudon'
            ],
            [
                'firstname'=>'Anne Marie',
                'lastname'=>'Loop'
            ],
            [
                'firstname'=>'Pietro',
                'lastname'=>'Varasso'
            ],
            [
                'firstname'=>'Laurent',
                'lastname'=>'Caron'
            ],
        ];

        foreach ($artists as $record) {
            $artist = new Artist();
            $artist->setFirstname($record['firstname']);
            $artist->setLastname($record['lastname']);

            $manager->persist($artist);
        }

        $manager->flush();
        
    }
}
