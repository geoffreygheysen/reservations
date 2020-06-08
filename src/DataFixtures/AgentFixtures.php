<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Agent;

class AgentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $agents = [
           [
            'name'=>'Bob',
            'email'=>'bob@sull.be',
           ],
           [
            'name'=>'Fred',
            'email'=>'fred@sull.be',
           ],
           
       ];

       foreach ($agents as $record) {
        $agent = new Agent();
        $agent->setName($record['name']);
        $agent->setEmail($record['email']);
        
        $manager->persist($agent);

        $this->addReference($record['email'], $agent);
    }


        $manager->flush();
    }
}
