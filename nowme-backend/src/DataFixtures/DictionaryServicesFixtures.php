<?php

namespace NowMe\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use NowMe\Entity\ServiceDictionary;

class DictionaryServicesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $services = [
            ['name' => 'Strzyżenie',],
            ['name' => 'Manicure hybrydowy',],
            ['name' => 'Strzyżenie męskie',],
            ['name' => 'Strzyżenie brody',],
            ['name' => 'Paznokcie żelowe',],
            ['name' => 'Henna brwi',],
            ['name' => 'Pedicure hybrydowy',],
            ['name' => 'Przedłużanie rzęs',],
        ];

        foreach ($services as $service) {
            $manager->persist(new ServiceDictionary($service['name']));
        }

        $manager->flush();
    }
}
