<?php
namespace KingdomHall\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task
 * @package KingdomHall\DataBundle\Entity
 *
 * @ORM\Entity(repositoryClass="KingdomHall\TaskBundle\Repository\TaskRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Task {
    const TASK_STATUS_NEW = 'NEW';
    const TASK_STATUS_PENDING = 'PENDING';
    const TASK_STATUS_SUCCESS = 'SUCCESS';
    const TASK_STATUS_ERROR = 'ERROR';

    /**
     * Update the update date on every save
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function updateUpdateDate()
    {
        $this->setLastUpdateDate(new \DateTime());
    }

    /**
     * Set the status to NEW when first creating job
     *
     * @ORM\PrePersist
     * @return void
     */
    public function setStatusNew()
    {
        $this->setStatus(self::TASK_STATUS_NEW);
    }

    /**
     * Set the creation date when persisting a new job
     *
     * @ORM\PrePersist
     * @return void
     */
    public function setCreationDateNow()
    {
        $this->setCreationDate(new \DateTime());
    }

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime $creationDate
     *
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $lastUpdateDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=15)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=63)
     */
    private $task;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $parameters;

    /**
     * @var string
     *
     * @ORM\Column(type="text", length=2047, nullable=true)
     */
    private $errorMessage;

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate the creation date
     *
     * @return void
     */
    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set id
     *
     * @param int $id int
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastUpdateDate
     *
     * @param \DateTime $lastUpdateDate \DateTime
     *
     * @return void
     */
    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate;
    }

    /**
     * Set status
     *
     * @param string $status string
     *
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get lastUpdateDate
     *
     * @return \DateTime
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set task
     *
     * @param string $task string
     *
     * @return void
     */
    public function setTask($task)
    {
        $this->task = $task;
    }

    /**
     * Get task
     *
     * @return string
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set parameters
     *
     * @param mixed $parameters mixed
     *
     * @return void
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Get parameters
     *
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set errorMessage
     *
     * @param mixed $errorMessage mixed
     *
     * @return void
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * Get errorMessage
     *
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * getLastUpdateDateIso
     *
     * @return string
     */
    public function getLastUpdateDateIso()
    {
        return $this->lastUpdateDate->format(\DateTime::ISO8601);
    }

    /**
     * getCreationDateIso
     *
     * @return string
     */
    public function getCreationDateIso()
    {
        return $this->creationDate->format(\DateTime::ISO8601);
    }

}
