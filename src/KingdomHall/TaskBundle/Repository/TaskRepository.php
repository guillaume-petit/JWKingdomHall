<?php
namespace KingdomHall\TaskBundle\Repository;

use Doctrine\ORM\EntityRepository;
use KingdomHall\TaskBundle\Entity\Task;

class TaskRepository extends EntityRepository
{
    const HISTORY_TIME_FRAME = '7 days ago';

    /**
     * Get new tasks to be processed
     *
     * @return Task[]
     */
    public function getNewJobs()
    {
        return $this->findBy(
            array (
                'status' => Task::TASK_STATUS_NEW,
            ),
            array (
                'creationDate' => 'ASC',
            )
        );
    }

    /**
     * Purge the cron history table, deleting records older than HISTORY_TIME_FRAME
     *
     * @return void
     */
    public function purge()
    {
        $date = date('Y-m-d H:i:s', strtotime(self::HISTORY_TIME_FRAME));

        $this->_em
            ->createQuery(
                'DELETE FROM KingdomHallTaskBundle:Task ch
                WHERE  ch.lastUpdateDate < :date'
            )
            ->setParameter('date', $date)
            ->execute();
    }

    /**
     * addJob
     *
     * @param string $task       the task name
     * @param array  $parameters the task parameters
     *
     * @return void
     */
    public function addJob($task, $parameters = array())
    {
        $job = new Task();
        $job->setTask($task);
        $job->setParameters(json_encode($parameters));
        $this->_em->persist($job);
        $this->_em->flush($job);
    }
}