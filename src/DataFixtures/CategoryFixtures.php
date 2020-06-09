<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = [
            [
                'category'=> 'Comédie',
            ],
            [
                'category'=> 'Drame',
            ],
            [
                'category'=> 'Familiale',
            ],
        ];

        foreach ($categories as $record) {
            $category = new Category();

            $category->setCategory($record['category']);

            $manager->persist($category);

            $this->addReference($record['category'], $category);

        }
        
        $manager->flush();
    }
}
