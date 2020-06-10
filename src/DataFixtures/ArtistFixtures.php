<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Artist;

class ArtistFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $artists =[
            [
                'firstname'=>'Daniel',
                'lastname'=>'Marcelin',
                'agent'=>'bob@sull.be',
            ],
            [
                'firstname'=>'Philippe',
                'lastname'=>'Laurent',
                'agent'=>'bob@sull.be',
            ],
            [
                'firstname'=>'Marius',
                'lastname'=>'Von Mayenburg',
                'agent'=>'bob@sull.be',
            ],
            [
                'firstname'=>'Olivier',
                'lastname'=>'Boudon',
                'agent'=>null,
            ],
            [
                'firstname'=>'Anne Marie',
                'lastname'=>'Loop',
                'agent'=>'fred@sull.be',
            ],
            [
                'firstname'=>'Pietro',
                'lastname'=>'Varasso',
                'agent'=>'fred@sull.be',
            ],
            [
                'firstname'=>'Laurent',
                'lastname'=>'Caron',
                'agent'=>'bob@sull.be',
            ],
            [
                'firstname'=>'Élena',
                'lastname'=>'Perez',
                'agent'=>'bob@sull.be',
            ],
            [
                'firstname'=>'Guillaume',
                'lastname'=>'Alexandre',
                'agent'=>'bob@sull.be',
            ],
            [
                'firstname'=>'Claude',
                'lastname'=>'Semal',
                'agent'=>'bob@sull.be',
            ],
            [
                'firstname'=>'Laurence',
                'lastname'=>'Warin',
                'agent'=>'bob@sull.be',
            ],
            [
                'firstname'=>'Pierre',
                'lastname'=>'Wayburn',
                'agent'=>'bob@sull.be',
            ],
            [
                'firstname'=>'Gwendoline',
                'lastname'=>'Gauthier',
                'agent'=>'fred@sull.be',
            ],
        ];

        foreach ($artists as $record) {
            $artist = new Artist();

            $artist->setFirstname($record['firstname']);
            $artist->setLastname($record['lastname']);
            if (!empty($record['agent'])) {
                $artist->setAgent($this->getReference($record['agent']));
            }
            
            $this->addReference(
                $record['firstname']."-".$record['lastname'],
                $artist
            );

            $manager->persist($artist);

        }

        $manager->flush();
        
    }
    public function getDependencies() {
        return [
            AgentFixtures::class,
        ];
    }
}
