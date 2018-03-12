<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Cities;
use AppBundle\Entity\Countries;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CitiesData extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $cities1 = new Cities();
        $cities1->setLabel('Nantes');
        $cities1->setCountries($this->getReference('countries1'));
        $this->addReference('cities1', $cities1);

        $manager->persist($cities1);

        $manager->flush();
    }

    /**
     * Order to trigger fixture
     */
    public function getOrder()
    {
        return 2;
    }

}
