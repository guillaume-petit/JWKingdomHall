<?php
namespace KingdomHall\TaskBundle\Service;

use Doctrine\ORM\EntityManager;
use KingdomHall\TaskBundle\Entity\Task;

class CronService
{
    /**
     * @var TaskService[]
     */
    private $taskServices;

    /** @var EntityManager $entityManager*/
    protected $entityManager;

    /**
     * Constructor
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->taskServices = array();
    }

    /**
     * Add a task service to the array of task services
     *
     * @param mixed $service a service tagged as cron task
     *
     * @return void
     */
    public function addTaskService($service)
    {
        $this->taskServices[$service->getName()] = $service;
    }

    /**
     * getTaskServices
     *
     * @return array|TaskService[]
     */
    public function getTaskServices()
    {
        return $this->taskServices;
    }

    /**
     * Run all new tasks
     *
     * @throws \InvalidArgumentException
     * @return void
     */
    public function runJobs()
    {
        $cronRepo = $this->entityManager->getRepository('KingdomHallTaskBundle:Task');
        $jobs = $cronRepo->getNewJobs();

        foreach ($jobs as $job) {
            $task = $job->getTask();
            if (!array_key_exists($task, $this->taskServices)) {
                throw new \InvalidArgumentException($task . ' service not found. Available task services : ' . implode(', ', array_keys($this->taskServices)));
            }

            $service = $this->taskServices[$task];
            $parameters = json_decode($job->getParameters());

            $job->setStatus(Task::TASK_STATUS_PENDING);
            $this->entityManager->persist($job);
            $this->entityManager->flush();
            try {
                $service->process($job->getId(), $parameters);
            } catch (\Exception $e) {
                $job->setStatus(Task::TASK_STATUS_ERROR);
                $job->setErrorMessage($e->getMessage());
                $this->entityManager->persist($job);
                $this->entityManager->flush();
                return;
            }
            $job->setStatus(Task::TASK_STATUS_SUCCESS);
            $this->entityManager->persist($job);
            $this->entityManager->flush();
        }

        // Purge old jobs
        $cronRepo->purge();
    }

    /**
     * addJob
     *
     * @param string $task       the task name
     * @param array  $parameters an array of parameters
     *
     * @throws \InvalidArgumentException
     * @return void
     */
    public function addJob($task, $parameters = array())
    {
        if (!array_key_exists($task, $this->taskServices)) {
            throw new \InvalidArgumentException($task . ' task not found. Available tasks : ' . implode(', ', array_keys($this->taskServices)));
        }
        $this->entityManager->getRepository('KingdomHallTaskBundle:Task')->addJob($task, $parameters);
    }

    /**
     * getJobs
     *
     * @return array|Task[]
     */
    public function getJobs()
    {
        return $this->entityManager->getRepository('KingdomHallTaskBundle:Task')->findBy(array(), array ('id' => 'DESC'));
    }
}