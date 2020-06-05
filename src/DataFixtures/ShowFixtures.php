<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Show;
use Cocur\Slugify\Slugify;

class ShowFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $shows = [
            [
                'slug'=> null,
                'title'=> 'Ayiti',
                'description'=> 'Un homme est bloqué à l\'aéroport...',
                'poster_url'=> 'ayiti.jpg',
                'location_slug'=> 'espace-delvaux-la-venerie',
                'bookable'=> true,
                'price'=> 8.50,
            ],
            [
                'slug'=> null,
                'title'=> 'Cible mouvante',
                'description'=> 'Dans ce thriller les adultes semblent...',
                'poster_url'=> 'ciblemouvante.jpg',
                'location_slug'=> 'dexia-art-center',
                'bookable'=> true,
                'price'=> 9.00,
            ],
            [
                'slug'=> null,
                'title'=> 'Ceci n\'est pas un chanteur belge',
                'description'=> 'Non peut etre ?!',
                'poster_url'=> 'chanteurbelge.jpg',
                'location_slug'=> null,
                'bookable'=> false,
                'price'=> 5.50,
            ],
            [
                'slug'=> null,
                'title'=> 'Manneke...!',
                'description'=> 'A tour de role...',
                'poster_url'=> 'manneke.jpg',
                'location_slug'=> 'la-samaritaine',
                'bookable'=> true,
                'price'=> 10.50,
            ],
        ];

        foreach ($shows as $record) {
            $slugify = new Slugify();

            $show = new Show();
            $show->setSlug($slugify->slugify($record['title']));

            $show->setTitle($record['title']);
            $show->setDescription($record['description']);
            $show->setPosterUrl($record['poster_url']);

            if ($record['location_slug']) {
                $show->setLocation($this->getReference($record['location_slug']));
            }

            $show->setBookable($record['bookable']);
            $show->setPrice($record['price']);

            $this->addReference($show->getSlug(), $show);

            $manager->persist($show);

        }

        $manager->flush();
    }
    
    public function getDependencies() {
        return [
            LocationFixtures::class,
        ];
    }
}
