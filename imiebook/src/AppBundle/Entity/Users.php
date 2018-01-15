<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApplicationRepository")
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $lastname;

    /**
     * Construct
     * @param string $surname
     * @param string $lastname
     */
    public function __construct($surname, $lastname) {
        $this->surname = $surname;
        $this->lastname = $lastname;
    }

    public function toArray() {
        return array(
            "lastname" => $this->lastname,
            "surname" => $this->surname
        );
    }

}
