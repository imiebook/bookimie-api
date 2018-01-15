<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UsersData extends Fixture
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

}
