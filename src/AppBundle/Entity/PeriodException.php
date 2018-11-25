<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints\PeriodExceptionConstraint;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PeriodException
 *
 * @ORM\Table(name="period_exception")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PeriodExceptionRepository")
 * @PeriodExceptionConstraint()
 */
class PeriodException
{
    /**
     * Add an exception used to exclude some periods
     */
    const TYPE_EXCLUSION = 'EXCLUSION';
    /**
     * Add an exception used to add some extra shifts
     */
    const TYPE_ADD = 'ADD';

    /**
     * Exceptions used only one time, it works for every interval, even between different years
     */
    const RECURRENCE_NONE = 'NONE';
    /**
     * Exception repeated every year during the same interval
     * Must be on the same year !
     */
    const RECURRENCE_YEARLY = 'YEARLY';
    /**
     * Exception repeated every months during the same interval
     * Must be on the same month !
     * For end of month, it doesn't overlap to the next month
     */
    const RECURRENCE_MONTHLY = 'MONTHLY';
    /**
     * Exception repeated every weeks during the same day interval
     * Must be on the same week !
     */
    const RECURRENCE_WEEKLY = 'WEEKLY';
    /**
     * Exception repeated every days during a time interval
     * The date doesn't matter at all
     */
    const RECURRENCE_DAILY = 'DAILY';

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
     * @Assert\NotNull()
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @Assert\NotNull()
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @ORM\Column(name="recurrence", type="string")
     */
    private $recurrence = self::RECURRENCE_NONE;

    /**
     * @var Job

     * @ORM\ManyToOne(targetEntity="Job")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id", nullable=true)
     */
    private $job;

    /**
     * @var Formation

     * @ORM\ManyToOne(targetEntity="Formation")
     * @ORM\JoinColumn(name="formation_id", referencedColumnName="id", nullable=true)
     */
    private $formation;

    /**
     * @var PeriodExceptionReason
     *
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PeriodExceptionReason")
     * @ORM\JoinColumn(name="reason_id", referencedColumnName="id", nullable=false)
     */
    private $reason;

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
     * @return \DateTime
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(?\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(?\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getRecurrence(): ?string
    {
        return $this->recurrence;
    }

    /**
     * @param string $recurrence
     */
    public function setRecurrence(?string $recurrence): void
    {
        $this->recurrence = $recurrence;
    }

    /**
     * @return Job
     */
    public function getJob(): ?Job
    {
        return $this->job;
    }

    /**
     * @param Job $job
     */
    public function setJob(?Job $job): void
    {
        $this->job = $job;
    }

    /**
     * @return PeriodExceptionReason
     */
    public function getReason(): ?PeriodExceptionReason
    {
        return $this->reason;
    }

    /**
     * @param PeriodExceptionReason $reason
     */
    public function setReason(?PeriodExceptionReason $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @return Formation
     */
    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    /**
     * @param Formation $formation
     */
    public function setFormation(?Formation $formation): void
    {
        $this->formation = $formation;
    }
}
