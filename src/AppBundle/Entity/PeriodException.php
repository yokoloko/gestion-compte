<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="period_exception")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PeriodExceptionRepository")
 */
class PeriodException
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", unique=true)
     */
    private $date;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\OneToMany(targetEntity="Period", mappedBy="exception",cascade={"persist", "remove"})
     */
    private $periods;

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return PeriodException
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add period
     *
     * @param \AppBundle\Entity\Period $period
     *
     * @return PeriodException
     */
    public function addPeriod(\AppBundle\Entity\Period $period)
    {
        $this->periods[] = $period;

        return $this;
    }

    /**
     * Remove period
     *
     * @param \AppBundle\Entity\Period $period
     */
    public function removePeriod(\AppBundle\Entity\Period $period)
    {
        $this->periods->removeElement($period);
    }

    /**
     * Get periods
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPeriods()
    {
        return $this->periods;
    }
}
