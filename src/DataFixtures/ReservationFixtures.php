<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Reservation;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $reservations = [
            [
                'representation'=>'ayiti-20121012133000',
                'utilisateur'=>'geoffino',
                'places'=>2,
            ],
            [
                'representation'=>'cible-mouvante-20121002203000',
                'utilisateur'=>'geoffino',
                'places'=>1,
            ],
            [
                'representation'=>'cible-mouvante-20121002203000',
                'utilisateur'=>'johnny',
                'places'=>2,
            ],
            [
                'representation'=>'ceci-n-est-pas-un-chanteur-belge-20121016203000',
                'utilisateur'=>'geoffino',
                'places'=>3,
            ],
        ];
        
        foreach($reservations as $record) {
            $reservation = new Reservation();

            $reservation->setRepresentation($this->getReference($record['representation']));
            $reservation->setUtilisateur($this->getReference($record['utilisateur']));

            $reservation->setPlaces($record['places']);
                        
            $this->addReference($record['representation']."-".$record['utilisateur'], $reservation);

            $manager->persist($reservation);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            RepresentationFixtures::class,
            UtilisateurFixtures::class,
        ];
    }

}