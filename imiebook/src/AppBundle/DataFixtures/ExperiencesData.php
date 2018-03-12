<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Experiences;
use AppBundle\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ExperiencesData extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $experiencences1 = new Experiences();
        $experiencences1->setTitle('Développeur');
        $experiencences1->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        $experiencences1->setEnterprise('Pole Emploi');
        $experiencences1->setDateStart(new \DateTime("now"));
        $experiencences1->setDateEnd(new \DateTime("now"));
        $this->addReference('experiences1', $experiencences1);

        $manager->persist($experiencences1);

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
