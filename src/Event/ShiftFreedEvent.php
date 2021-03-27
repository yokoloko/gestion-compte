<?php

namespace App\Event;

use App\Entity\Membership;
use App\Entity\Shift;
use Symfony\Component\EventDispatcher\Event;

class ShiftFreedEvent extends Event
{
    const NAME = 'shift.freed';

    private $shift;
    private $membership;

    public function __construct(Shift $shift, Membership $membership)
    {
        $this->shift = $shift;
        $this->membership = $membership;
    }

    /**
     * @return Membership
     */
    public function getMembership()
    {
        return $this->membership;
    }

    /**
     * @return Shift
     */
    public function getShift()
    {
        return $this->shift;
    }

}
