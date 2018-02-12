<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UsersData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user1 = new Users();
        $user1->setUsername('test');
        $user1->setPassword('test');
        $user1->setLastname('Erwan');
        $user1->setSurname('Guillet');
        $user1->setEmail('test@test.fr');
        $manager->persist($user1);

        $manager->flush();

        $this->addReference('user1', $user1);
    }

}
