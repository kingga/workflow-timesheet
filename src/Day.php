<?php

/**
 * This file contains the Day storage class.
 *
 * @author Isaac Skelton <contact@isaacskelton.com>
 * @since 1.0.0
 * @package Kingga\Workflow
 */

namespace Kingga\Workflow;

use DateTime;

/**
 * The day storage class.
 */
class Day
{
    /**
     * The date which this day is for.
     *
     * @var DateTime
     */
    protected $date;

    /**
     * An array of entries for this day.
     *
     * @var Entry[]
     */
    protected $entries = [];

    /**
     * Setup the day with the date this container is for.
     *
     * @param DateTime $date The date for this day.
     */
    public function __construct(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Add an entry onto this day.
     *
     * @param Entry $entry The entry to add to this day.
     *
     * @return self For chaining.
     */
    public function addEntry(Entry $entry): self
    {
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Getter for the assigned entries on this day.
     *
     * @return Entry[] The entries assigned to this day.
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Getter for the date for this day.
     *
     * @return DateTime The date for this day.
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * Get the name of this day, e.g. Monday, Tuesday, ...
     *
     * @var string The name of the day.
     */
    public function getDayName(): string
    {
        return $this->date->format('l');
    }

    /**
     * Get how much time was spent on this day.
     *
     * @return float The time spent on this day.
     */
    public function getTotalTime(): float
    {
        $time = 0.0;

        foreach ($this->entries as $entry) {
            $time += $entry->getTime();
        }

        return $time;
    }
}
