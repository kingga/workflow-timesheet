<?php

/**
 * This file contains the Week storage class.
 *
 * @author Isaac Skelton <contact@isaacskelton.com>
 * @since 1.0.0
 * @package Kingga\WorkflowTimesheet
 */

namespace Kingga\WorkflowTimesheet;

use DateTime;
use Kingga\WorkflowTimesheet\Day;

/**
 * The week storage class.
 */
class Week
{
    /**
     * The start date for the week.
     *
     * @var DateTime
     */
    protected $start;

    /**
     * The end date for the week.
     *
     * @var DateTime
     */
    protected $end;

    /**
     * The days which are in this week.
     *
     * @var Day[]
     */
    protected $days = [];

    /**
     * Setter for the start date.
     *
     * @param DateTime $start The start date for the week.
     *
     * @return self For chaining.
     */
    public function setStart(DateTime $start): self
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Setter for the end date.
     *
     * @param DateTime $end The end date for the week.
     *
     * @return self For chaining.
     */
    public function setEnd(DateTime $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get the start date of the week.
     *
     * @return DateTime The start date.
     */
    public function getStart(): DateTime
    {
        return $this->start;
    }

    /**
     * Get the end date of the week.
     *
     * @return DateTime The end date.
     */
    public function getEnd(): DateTime
    {
        return $this->end;
    }

    /**
     * Add a day to this week.
     *
     * @param Day $day The day with all of it's entries.
     *
     * @return self For chaining.
     */
    public function addDay(Day $day): self
    {
        $this->days[] = $day;

        return $this;
    }

    /**
     * Return an array of all of the days.
     *
     * @return Day[] The days.
     */
    public function getDays(): array
    {
        return $this->days;
    }

    /**
     * Get the day of the week using a one based index, e.g. 1 = Monday, 2 = Tuesday, ...
     *
     * @param int $day The day of the week starting at 1.
     *
     * @return Day|null The day if it is found.
     */
    public function getDay(int $day): ?Day
    {
        // NOTE: DateTime::format('w') => 0 Sunday, 6 Saturday.
        if ($day === 7) {
            $day = 0;
        }

        foreach ($this->getDays() as $d) {
            if (((int) $d->getDate()->format('w')) === $day) {
                return $d;
            }
        }

        return null;
    }

    /**
     * Get the total amount of worked hours for this week.
     *
     * @return float The worked hours for this week.
     */
    public function getTotalTime(): float
    {
        $time = 0.0;

        foreach ($this->days as $day) {
            $time += $day->getTotalTime();
        }

        return $time;
    }
}
