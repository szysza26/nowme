<?php

namespace NowMe\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use NowMe\Entity\SpecialistDictionary;

class DictionarySpecialistsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $services = [
            ['name' => 'Fryzjer',],
            ['name' => 'Kosmetyczka',],
            ['name' => 'Elektryk',],
            ['name' => 'Mechanik',],
            ['name' => 'Hydraulik',],
            ['name' => 'Malarz',],
        ];

        foreach ($services as $service) {
            $manager->persist(new SpecialistDictionary($service['name']));
        }

        $manager->flush();
    }
}
