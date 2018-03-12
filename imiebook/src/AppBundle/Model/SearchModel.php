<?php
// src/Model/SearchModel.php
namespace AppBundle\Model;

class SearchModel
{

    /** is input search */
    private $label;

    /** list of filter */
    private $filters;


    /**
     * Get the value of Label
     *
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of Label
     *
     * @param mixed label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the value of Filters
     *
     * @return mixed
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set the value of Filters
     *
     * @param mixed filters
     *
     * @return self
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;

        return $this;
    }

}
