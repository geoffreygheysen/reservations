<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Locality;

class LocalityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $localities = [
            [
                'locality'=>'Bruxelles',
                'postal_code'=>'1000'
            ],
            [
                'locality'=>'Laeken',
                'postal_code'=>'1020'
            ],
            [
                'locality'=>'Schaerbeek',
                'postal_code'=>'1030'
            ],
            [
                'locality'=>'Ixelles',
                'postal_code'=>'1050'
            ],
            [
                'locality'=>'Watermael-Boitsfort',
                'postal_code'=>'1170'
            ],
        ];
        foreach ($localities as $record) {
            $locality = new Locality();
            $locality->setLocality($record['locality']);
            $locality->setPostalCode($record['postal_code']);

            $manager->persist($locality);

            $this->addReference($record['locality'], $locality);
        }

        $manager->flush();
    }
}
