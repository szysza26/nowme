<?php

namespace NowMe\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use NowMe\Entity\Office;
use NowMe\Entity\ServiceDictionary;
use NowMe\Entity\User;
use NowMe\Entity\Service;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;


class AppFixtures extends Fixture
{
    private EncoderFactoryInterface $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }


    public function load(ObjectManager $manager)
    {
        $me = User::create(
            "szysza",
            "szy162@gmail.com",
            $this->encoderFactory->getEncoder(User::class)->encodePassword("test123", null),
            "Krzysztof",
            "Gorzynski",
            "123456789",
            "884395806"
        );
        $me->assignAs("ROLE_USER");
        $manager->persist($me);

        for($i = 1; $i <= 5; $i++) {
            $role = "ROLE_USER";
            if($i == 4) $role = "ROLE_SPECIALIST";
            if($i == 5) $role = "ROLE_ADMIN";
            $user = User::create(
                "user".$i,
                "email".$i."@gmail.com",
                $this->encoderFactory->getEncoder(User::class)->encodePassword("test123", null),
                "imie".$i,
                "nazwisko".$i,
                "123456789".$i,
                "123456789"
            );
            $user->assignAs($role);

            if($i == 4){
                for($j = 1; $j <= 5; $j++) {
                    $office = new Office();
                    $office->setName("Gabinet1".$j);
                    $office->setStreet("Wyzwolenia");
                    $office->setHouseNumber("".(5+ $j));
                    $office->setCity("Szczecin");
                    $office->setZip("70-552");

                    $office->addSpecialist($user);
                    $user->addOffice($office);

                    $manager->persist($office);

                    $service = new Service();
                    $name = new ServiceDictionary("Test".$j);
                    $manager->persist($name);
                    $service->setName($name);
                    $service->setDuration(1 + $j);
                    $service->setPrice(1 + $j);

                    $service->setSpecialist($user);
                    $user->addOffice($office);

                    $manager->persist($service);
                }
            }

            $manager->persist($user);
        }

        $manager->flush();
    }
}
