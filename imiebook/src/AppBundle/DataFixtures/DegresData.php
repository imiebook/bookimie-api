<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Degres;
use AppBundle\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class DegresData extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $degre1 = new Degres();
        $degre1->setTitle('CPCSI IMIE - BAC + 5');
        $degre1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $degre1->setEnterprise('IMIE');
        $degre1->setDateStart(new \DateTime("now"));
        $degre1->setDateEnd(new \DateTime("now"));
        $this->addReference('degre1', $degre1);

        $manager->persist($degre1);

        $manager->flush();
    }

    /**
     * Order to trigger fixture
     */
    public function getOrder()
    {
        return 3;
    }

}
