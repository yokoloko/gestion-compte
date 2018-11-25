<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\PeriodException;
use Carbon\Carbon;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PeriodExceptionConstraintValidator extends ConstraintValidator
{
    /**
     * @param PeriodException $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof PeriodExceptionConstraint) {
            throw new UnexpectedTypeException($constraint, PeriodExceptionConstraint::class);
        }

        if (null === $value || !($value instanceof PeriodException)) {
            return;
        }

        if ($value->getStartDate() && $value->getEndDate()) {
            $startDate = Carbon::instance($value->getStartDate());
            $endDate = Carbon::instance($value->getEndDate());

            if ($endDate->lessThanOrEqualTo($startDate)) {
                $this->context->buildViolation('La date de début doit être avant la date de fin.')
                    ->atPath('startDate')
                    ->addViolation();
            }

            if ($value->getRecurrence() === PeriodException::RECURRENCE_DAILY) {
                // Here we want to compare the time only to be sure the end time is greater than the start time
                $todayStartTime = Carbon::now()->setTimeFrom($startDate);
                $todayEndTime = Carbon::now()->setTimeFrom($endDate);
                if ($todayEndTime->lessThanOrEqualTo($todayStartTime)) {
                    $this->context->buildViolation('L\'heure de début ne doit pas dépasser l\heure de fin.')
                        ->atPath('startDate')
                        ->addViolation();
                }
            } else if ($value->getRecurrence() === PeriodException::RECURRENCE_WEEKLY) {
                // Check the day of week
                if ($endDate->dayOfWeekIso <= $startDate->dayOfWeekIso) {
                    $this->context->buildViolation('La jour de semaine de début ne doit pas dépasser celui de fin.')
                        ->atPath('startDate')
                        ->addViolation();
                }
            } else if ($value->getRecurrence() === PeriodException::RECURRENCE_MONTHLY) {
                if ($endDate->day <= $startDate->day ||  $endDate->month !== $startDate->month) {
                    $this->context->buildViolation('Le jour de début ne doit pas dépasser le jour de fin dans le MEME mois.')
                        ->atPath('startDate')
                        ->addViolation();
                }
            } else if ($value->getRecurrence() === PeriodException::RECURRENCE_YEARLY) {
                if ($endDate->dayOfYear <= $startDate->dayOfYear || $endDate->year !== $startDate->year) {
                    $this->context->buildViolation('La date de début ne doit pas dépasser la date de fin dans la MEME année.')
                        ->atPath('startDate')
                        ->addViolation();
                }
            }
        }
    }
}