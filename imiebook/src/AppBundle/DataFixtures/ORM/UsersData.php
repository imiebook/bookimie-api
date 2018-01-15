<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Users;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UsersData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new Users();
        $user1->setLastname('Erwan');
        $user1->setSurname('Guillet');
        $manager->persist($user1);

        $manager->flush();

        $this->addReference('user1', $user1);
    }

    public function getOrder()
    {
        return 2;
    }
}
