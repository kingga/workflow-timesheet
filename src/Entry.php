<?php

/**
 * This file contains the Entry storage class.
 *
 * @author Isaac Skelton <contact@isaacskelton.com>
 * @since 1.0.0
 * @package Kingga\WorkflowTimesheet
 */

namespace Kingga\WorkflowTimesheet;

/**
 * The entry storage class.
 */
class Entry
{
    /**
     * The clients name.
     *
     * @var string
     */
    protected $client;

    /**
     * The Workflow job ID.
     *
     * @var string
     */
    protected $job_id;

    /**
     * The jobs name.
     *
     * @var string
     */
    protected $job;

    /**
     * The tasks name.
     *
     * @var string
     */
    protected $task;

    /**
     * The time spent on this entry/task.
     *
     * @var float
     */
    protected $time;

    /**
     * Setup the entry with all of the required information.
     *
     * @param string $client The clients name.
     * @param string $job_id The jobs ID.
     * @param string $job The name of the job.
     * @param string $task The name of the task.
     * @param float $time The time spent on the task.
     */
    public function __construct(string $client, string $job_id, string $job, string $task, float $time)
    {
        $this->client = $client;
        $this->job_id = $job_id;
        $this->job = $job;
        $this->task = $task;
        $this->time = $time;
    }

    /**
     * Getter for the client.
     *
     * @return string The client.
     */
    public function getClient(): string
    {
        return $this->client;
    }

    /**
     * The getter for the job ID.
     *
     * @return string The job ID.
     */
    public function getJobId(): string
    {
        return $this->job_id;
    }

    /**
     * Getter for the job name.
     *
     * @return string The name of the job.
     */
    public function getJob(): string
    {
        return $this->job;
    }

    /**
     * Getter for the tasks name.
     *
     * @return string The name of the task.
     */
    public function getTask(): string
    {
        return $this->task;
    }

    /**
     * Getter for the time spent on the job.
     *
     * @return float The time spent on the job.
     */
    public function getTime(): float
    {
        return $this->time;
    }
}
