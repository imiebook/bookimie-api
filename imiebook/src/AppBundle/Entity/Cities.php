<?php
// src/Entity/Cities.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="cities")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CitiesRepository")
 */
class Cities
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
     * @ORM\ManyToOne(targetEntity="Countries")
     * @ORM\JoinColumn(name="countries_id", referencedColumnName="id")
     */
    private $countries;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

  
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
     * Get the value of label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of label
     *
     * @param string label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

     /**
     * Get the value of countries
     *
     * @return string
     */
    public function getCountries()
    {
        return $this->countries;
    }

    /**
     * Set the value of countries
     *
     * @param string countries
     *
     * @return self
     */
    public function setCountries($countries)
    {
        $this->countries = $countries;

        return $this;
    }
   
}
