<?php

/**
 * This file contains the Workflow CSV parser.
 *
 * @author Isaac Skelton <contact@isaacskelton.com>
 * @since 1.0.0
 * @package Kingga\WorkflowTimesheet
 */

namespace Kingga\WorkflowTimesheet;

use DateTime;
use Exception;
use Kingga\WorkflowTimesheet\Day;
use Kingga\WorkflowTimesheet\Week;
use Kingga\WorkflowTimesheet\Entry;

/**
 * This class is a parser for the Workflow 'Export as CSV' function.
 */
class Parser
{
    /**
     * This is the format of the Workflow date, e.g. 01-Jul-2019
     *
     * @var string
     */
    protected $date_regex = '([0-9]{2}-[A-Z]{1}[a-z]{2}-[0-9]{4})';

    /**
     * Parse the CSV file which has been exported from Workflow.
     *
     * @param string $file The path to the csv file to parse.
     *
     * @return Week The week object, this will include the parsed week, days and entries.
     */
    public function parse(string $file): Week
    {
        // Get the lines.
        $contents = file_get_contents($file);
        $lines = explode("\n", $contents);

        $week = new Week;
        $entries = [];

        foreach ($lines as $line) {
            $line = trim($line);

            // Seach for the period.
            if (substr($line, 0, 6) === 'Period') {
                [$week_start, $week_end] = $this->parsePeriod($line);
                $week->setStart($week_start);
                $week->setEnd($week_end);
            }

            // Look for each entry and sort them by their days.
            $date = [];
            $tmp = [];

            if (preg_match("/^({$this->date_regex})/", trim($line), $date)) {
                $date = $date[0];

                if (!isset($entries[$date])) {
                    $entries[$date] = [];
                }

                // Positions (After 'X' Comma):
                // 1: Client
                // 3: Job ID
                // 4: Job
                // 6: Task
                // 7: Time (not decimal)
                $entries[$date][] = new Entry(
                    $this->getColumn($line, 1),
                    $this->getColumn($line, 3),
                    $this->getColumn($line, 4),
                    $this->getColumn($line, 6),
                    $this->timeAsFloat($this->getColumn($line, 7))
                );
            }
        }

        foreach ($entries as $date => $items) {
            $day = new Day(DateTime::createFromFormat('d-M-Y', $date));

            foreach ($items as $entry) {
                $day->addEntry($entry);
            }

            $week->addDay($day);
        }

        return $week;
    }

    /**
     * Convert the time to a decimal/floating point format, e.g. 8:30 becomes 8.5.
     *
     * @param string $time The time as a string (human readable) format, e.g. 8:30
     *
     * @return float The decimal/floating point format of the passed time.
     */
    protected function timeAsFloat(string $time): float
    {
        if (empty($time) || strpos($time, ':') === false) {
            return 0.0;
        }

        [$hour, $minute] = explode(':', $time);
        $minute /= 60;

        return ((int) $hour) + $minute;
    }

    /**
     * Get the value at the given colunn (starting at zero).
     *
     * @param string $line The line to parse.
     * @param int $column The column which you want to get.
     *
     * @return string The columns value.
     */
    protected function getColumn(string $line, int $column): string
    {
        $col = 0;
        $in_quote = false;
        $out = '';
        $line = str_split($line);

        foreach ($line as $idx => $char) {
            if ($col === $column && !$in_quote && $char !== ',') {
                $out .= $char;
            }

            if ($char === ',' && !$in_quote) {
                $col++;
            }

            if ($char === '"') {
                $in_quote = !$in_quote;
            }
        }

        return $out;
    }

    /**
     * Convert the Workflows date format into a DateTime object.
     *
     * @throws Exception If the periods format is invalid.
     *
     * @return DateTime[] The start and end DateTime object.
     */
    protected function parsePeriod(string $line): array
    {
        // Format: 00-Aaa-0000
        $matches = [];
        $regex = "/{$this->date_regex}/";

        if (preg_match_all($regex, $line, $matches) === 2) {
            $start = DateTime::createFromFormat('d-M-Y', $matches[1][0]);
            $end = DateTime::createFromFormat('d-M-Y', $matches[1][1]);
        } else {
            throw new Exception('Invalid period.');
        }

        return [$start, $end];
    }
}
