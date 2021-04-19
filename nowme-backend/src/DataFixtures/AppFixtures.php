<?php

namespace NowMe\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use NowMe\Entity\Office;
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
                "123456789".$i
            );
            $user->assignAs($role);

            if($i == 4){
                for($j = 1; $j <= 5; $j++) {
                    $office = new Office();
                    $office->setName("Gabinet1".$j);
                    $office->setStreet("Ulica".$j);
                    $office->setHouseNumber("NR".$j);
                    $office->setCity("Miasto".$j);
                    $office->setZip("00-00".$j);

                    $office->addSpecialist($user);
                    $user->addOffice($office);

                    $manager->persist($office);

                    $service = new Service();
                    $service->setName("usługa".$j);
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
