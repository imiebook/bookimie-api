<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Skills;
use AppBundle\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class SkillsData extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $skill1 = new Skills();
        $skill1->setLabel('PHP');
        $this->addReference('skill1', $skill1);

        $manager->persist($skill1);

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
