<?php
// src/Entity/Experiences.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\DateTimeType;

/**
 * @ORM\Table(name="experiences")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExperiencesRepository")
 * @Search(repositoryClass="AppBundle\Repository\ExperiencesRepository")
 */
class Experiences
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="enterprise", type="string", length=255)
     */
    private $enterprise;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var date
     *
     * @ORM\Column(name="dateStart", type="datetime", nullable=true)
     */
    private $dateStart;

    /**
     * @var date
     *
     * @ORM\Column(name="dateEnd", type="datetime", nullable=true)
     */
    private $dateEnd;


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
     * Get the value of Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Title
     *
     * @param string title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of Enterprise
     *
     * @return string
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * Set the value of Enterprise
     *
     * @param string enterprise
     *
     * @return self
     */
    public function setEnterprise($enterprise)
    {
        $this->enterprise = $enterprise;

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
     * Get the value of Date Start
     *
     * @return date
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set the value of Date Start
     *
     * @param date dateStart
     *
     * @return self
     */
    public function setDateStart(\DateTime $dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get the value of Date End
     *
     * @return date
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set the value of Date End
     *
     * @param date dateEnd
     *
     * @return self
     */
    public function setDateEnd(\DateTime $dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

}
