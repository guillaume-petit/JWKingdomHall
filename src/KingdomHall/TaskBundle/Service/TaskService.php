<?php
namespace KingdomHall\TaskBundle\Service;

use KingdomHall\TaskBundle\Exception\TaskException;

abstract class TaskService {
    /**
     * process a task
     *
     * @param integer $jobId      the id of the job being processed
     * @param array   $parameters an array of parameters
     *
     * @throws TaskException
     * @return void
     */
    public abstract function process($jobId, $parameters = array());

    /**
     * get service task name
     *
     * @return string
     */
    public abstract function getName();
}