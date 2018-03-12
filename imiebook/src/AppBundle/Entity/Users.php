<?php
// src/Entity/Users.php
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Degres;
use AppBundle\Entity\Experiences;

/**
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 * @Search(repositoryClass="AppBundle\Repository\UsersRepository")
 */
class Users extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=14, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mobility", type="boolean", nullable=true)
     */
    private $mobility;

    /**
     * @ORM\ManyToMany(targetEntity="Degres", orphanRemoval=true, cascade={"all"})
     * @ORM\JoinTable(name="user_degres",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="degres_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $degres;

    /**
     * @ORM\ManyToMany(targetEntity="Experiences", orphanRemoval=true, cascade={"all"})
     * @ORM\JoinTable(name="user_experiences",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="experiences_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $experiences;

    public function __construct()
    {
        parent::__construct();
        $this->degres = new ArrayCollection();
    }

    /**
     * Add degre
     * @param Degres $degre [description]
     */
    public function addDegre(Degres $degre)
    {
        $this->degres[] = $degre;

        return $this;
    }

    /**
     * Remove degre
     * @param  Degres $degre [description]
     */
    public function removeDegre(Degres $degre)
    {
        $this->degres->removeElement($degre);
    }

    /**
     * Add experiences
     * @param Experiences $experiences
     */
    public function addExperiences(Experiences $experiences)
    {
        $this->experiences[] = $experiences;

        return $this;
    }

    /**
     * Remove experiences
     * @param  Experiences $experiences
     */
    public function removeExperiences(Experiences $experiences)
    {
        $this->experiences->removeElement($experiences);
    }

    /**
     * Get the value of Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set the value of Surname
     *
     * @param string surname
     *
     * @return self
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get the value of Lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of Lastname
     *
     * @param string lastname
     *
     * @return self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of Phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of Phone
     *
     * @param string phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of Description
     *
     * @param string description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of Mobility
     *
     * @return string
     */
    public function getMobility()
    {
        return $this->mobility;
    }

    /**
     * Set the value of Mobility
     *
     * @param string mobility
     *
     * @return self
     */
    public function setMobility($mobility)
    {
        $this->mobility = $mobility;

        return $this;
    }

    /**
     * Get the value of Degres
     *
     * @return mixed
     */
    public function getDegres()
    {
        return $this->degres;
    }

    /**
     * Set the value of Degres
     *
     * @param mixed degres
     *
     * @return self
     */
    public function setDegres($degres)
    {
        $this->degres = $degres;

        return $this;
    }

    /**
     * This object to array
     * @return array
     */
    public function toArray() {
        return get_object_vars($this);
    }

    /**
     * Get the value of Experiences
     *
     * @return mixed
     */
    public function getExperiences()
    {
        return $this->experiences;
    }

    /**
     * Set the value of Experiences
     *
     * @param mixed experiences
     *
     * @return self
     */
    public function setExperiences($experiences)
    {
        $this->experiences = $experiences;

        return $this;
    }

}
