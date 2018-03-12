<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Countries;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CountriesData extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $countries1 = new Countries();
        $countries1->setLabel('France');
        $this->addReference('countries1', $countries1);

        $manager->persist($countries1);

        $manager->flush();
    }

    /**
     * Order to trigger fixture
     */
    public function getOrder()
    {
        return 1;
    }

}
