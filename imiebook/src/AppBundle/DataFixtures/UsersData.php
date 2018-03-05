<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UsersData extends Fixture implements ContainerAwareInterface, OrderedFixtureInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new Users();
        $user1->setUsername('test');
        $encoder = $this->container->get('security.password_encoder');
        $user1->setPassword($encoder->encodePassword($user1, 'p@ssword'));
        $user1->setLastname('Erwan');
        $user1->setSurname('Guillet');
        $user1->setEmail('test@test.fr');
        $user1->setEnabled(true);

        $user2 = new Users();
        $user2->setUsername('imieUmake');
        $encoder = $this->container->get('security.password_encoder');
        $user2->setPassword($encoder->encodePassword($user2, 'p@ssword'));
        $user2->setLastname('Imie');
        $user2->setSurname('Book');
        $user2->setEmail('imieUmake@gmail.com');
        $user2->setEnabled(true);

        $manager->persist($user1);
        $manager->persist($user2);

        $manager->flush();

        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
    }

    /**
     * Order to trigger fixture
     */
    public function getOrder()
    {
        return 1;
    }

}
