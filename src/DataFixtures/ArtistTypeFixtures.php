<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtistTypeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $artistTypes = [
            [
                'artist_firstname'=> 'Daniel',
                'artist_lastname'=> 'Marcelin',
                'type'=> 'auteur',
            ],
            [
                'artist_firstname'=> 'Philippe',
                'artist_lastname'=> 'Laurent',
                'type'=> 'auteur',
            ],
            [
                'artist_firstname'=> 'Daniel',
                'artist_lastname'=> 'Marcelin',
                'type'=> 'scénographe',
            ],
            [
                'artist_firstname'=> 'Philippe',
                'artist_lastname'=> 'Laurent',
                'type'=> 'scénographe',
            ],
            [
                'artist_firstname'=> 'Daniel',
                'artist_lastname'=> 'Marcelin',
                'type'=> 'comédien',
            ],
            [
                'artist_firstname'=> 'Marius',
                'artist_lastname'=> 'Von Mayenburg',
                'type'=> 'auteur',
            ],
            [
                'artist_firstname'=> 'Olivier',
                'artist_lastname'=> 'Boudon',
                'type'=> 'scénographe',
            ],
            [
                'artist_firstname'=> 'Anne Marie',
                'artist_lastname'=> 'Loop',
                'type'=> 'comédien',
            ],
            [
                'artist_firstname'=> 'Pietro',
                'artist_lastname'=> 'Varasso',
                'type'=> 'comédien',
            ],
            [
                'artist_firstname'=> 'Laurent',
                'artist_lastname'=> 'Caron',
                'type'=> 'comédien',
            ],
        ];

        foreach ($artistTypes as $record) {
            //recuperer l'artiste(main entity)
           $artist = $this->getReference(
               $record['artist_firstname']."-".$record['artist_lastname']
            );
            //recuperer le type(secondary entity)
            $type = $this->getReference($record['type']);
            //definir son type
            $artist->addType($type);

            $manager->persist($artist);
        }

        $manager->flush();
    }
    public function getDependencies() {
        return [
            ArtistFixtures::class,
            TypeFixtures::class,
        ];
    }
}
