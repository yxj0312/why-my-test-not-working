<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
    )
    {
        
    }
    public function load(ObjectManager $manager): void
    {
       $this->loadProjects($manager);
    }

     private function loadProjects(ObjectManager $manager): void
    {
        foreach ($this-> as $key => $value) {
            # code...
        }
    }
}
