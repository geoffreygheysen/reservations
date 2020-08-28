<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Representation;

class RepresentationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $representations = [
            [
                'the_location'=> 'espace-delvaux-la-venerie',
                'the_show'=> 'ayiti',
                'schedule'=> new \DateTime('2012-10-12 13:30:00'),
            ],
            [
                'the_location'=> 'dexia-art-center',
                'the_show'=> 'ayiti',
                'schedule'=> new \DateTime('2012-10-12 20:30'),
            ],
            [
                'the_location'=> null,
                'the_show'=> 'cible-mouvante',
                'schedule'=> new \DateTime('2012-10-02 20:30'),
            ],
            [
                'the_location'=> null,
                'the_show'=> 'ceci-n-est-pas-un-chanteur-belge',
                'schedule'=> new \DateTime('2012-10-16 20:30'),
            ],
        ];

        foreach ($representations as $record) {

            $representation = new Representation();
            $representation->setTheShow($this->getReference($record['the_show']));

            if ($record['the_location']) {
                $representation->setTheLocation($this->getReference($record['the_location']));
            }

            $representation->setSchedule($record['schedule']);

            $manager->persist($representation);

            $reference = $record['the_show']."-".$record['schedule']->format('YmdHis');          
            $this->addReference($reference, $representation);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            LocationFixtures::class,
            ShowFixtures::class,
        ];
    }
}
