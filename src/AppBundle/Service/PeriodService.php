<?php

namespace AppBundle\Service;

use AppBundle\Entity\PeriodException;
use Doctrine\ORM\EntityManager;

class PeriodService
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {

        $this->em = $em;
    }

    public function isExcludedForDateInterval(\DateTime $startDate, \DateTime $endDate)
    {
        $qb = $this->em->getRepository('AppBundle:PeriodException')->createQueryBuilder('pe');
        // We compare the start shift date with the end date (and the opposite) of the exception to avoid generating any shift inside an exception
        $qb->orWhere(
            // One time exceptions
            $qb->expr()->andX(
                'pe.recurrence = :noRecurrence',
                'pe.startDate <= :endDate',
                'pe.endDate >= :startDate'
            ),
            // Daily exceptions
            $qb->expr()->andX(
                'pe.recurrence = :dailyRecurrence',
                // Safety check
                'TIME(pe.startDate) <= TIME(pe.endDate)',
                // Compare the time only
                'TIME(pe.startDate) <= TIME(:endDate)',
                'TIME(pe.endDate) >= TIME(:startDate)'
            ),
            // Weekly exceptions
            $qb->expr()->andX(
                'pe.recurrence = :weeklyRecurrence',
                // Safety check
                'DAYOFWEEK(pe.startDate) <= DAYOFWEEK(pe.endDate)',
                // Compare the start date
                $qb->expr()->orX(
                    'DAYOFWEEK(pe.startDate) < DAYOFWEEK(:endDate)',
                    $qb->expr()->andX(
                        'DAYOFWEEK(pe.startDate) = DAYOFWEEK(:endDate)',
                        'TIME(pe.startDate) <= TIME(:endDate)'
                    )
                ),
                // Compare the end date
                $qb->expr()->orX(
                    'DAYOFWEEK(pe.endDate) < DAYOFWEEK(:startDate)',
                    $qb->expr()->andX(
                        'DAYOFWEEK(pe.endDate) = DAYOFWEEK(:startDate)',
                        'TIME(pe.endDate) <= TIME(:startDate)'
                    )
                )
            ),
            // Monthly exceptions
            $qb->expr()->andX(
                'pe.recurrence = :monthlyRecurrence',
                // Safety check
                'DAY(pe.startDate) <= DAY(pe.endDate)',
                'MONTH(pe.startDate) = MONTH(pe.endDate)',
                // Compare the start date
                $qb->expr()->orX(
                    'DAY(pe.startDate) < DAY(:endDate)',
                    $qb->expr()->andX(
                        'DAY(pe.startDate) = DAY(:endDate)',
                        'TIME(pe.startDate) <= TIME(:endDate)'
                    )
                ),
                // Compare the end date
                $qb->expr()->orX(
                    'DAY(pe.endDate) < DAY(:startDate)',
                    $qb->expr()->andX(
                        'DAY(pe.endDate) = DAY(:startDate)',
                        'TIME(pe.endDate) <= TIME(:startDate)'
                    )
                )
            ),
            // Yearly exceptions
            $qb->expr()->andX(
                'pe.recurrence = :yearlyRecurrence',
                // Safety check
                'DAYOFYEAR(pe.startDate) <= DAYOFYEAR(pe.endDate)',
                'YEAR(pe.startDate) = YEAR(pe.endDate)',
                // Compare the start date
                $qb->expr()->orX(
                    'DAYOFYEAR(pe.startDate) < DAYOFYEAR(:endDate)',
                    $qb->expr()->andX(
                        'DAYOFYEAR(pe.startDate) = DAYOFYEAR(:endDate)',
                        'TIME(pe.startDate) <= TIME(:endDate)'
                    )
                ),
                // Compare the end date
                $qb->expr()->orX(
                    'DAYOFYEAR(pe.endDate) < DAYOFYEAR(:startDate)',
                    $qb->expr()->andX(
                        'DAYOFYEAR(pe.endDate) = DAYOFYEAR(:startDate)',
                        'TIME(pe.endDate) <= TIME(:startDate)'
                    )
                )
            )
        );
        $qb->andWhere('pe.type = :typeExclusion')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('typeExclusion', PeriodException::TYPE_EXCLUSION)
            ->setParameter('noRecurrence', PeriodException::RECURRENCE_NONE)
            ->setParameter('dailyRecurrence', PeriodException::RECURRENCE_DAILY)
            ->setParameter('weeklyRecurrence', PeriodException::RECURRENCE_WEEKLY)
            ->setParameter('monthlyRecurrence', PeriodException::RECURRENCE_MONTHLY)
            ->setParameter('yearlyRecurrence', PeriodException::RECURRENCE_YEARLY);

        $ret = $qb->getQuery()->getResult();
        return count($ret) > 0;
    }
}