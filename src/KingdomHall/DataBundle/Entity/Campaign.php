<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/7/15
 * Time: 9:29 AM
 */

namespace KingdomHall\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;


/**
 * Class Congregation
 * @package KingdomHall\DataBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table
 */
class Campaign {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Congregation
     * @ORM\ManyToOne(targetEntity="KingdomHall\DataBundle\Entity\Congregation", inversedBy="campaigns")
     * @ORM\JoinColumn(name="congregation_id", referencedColumnName="id")
     * @Exclude()
     */
    protected $congregation;

    /**
     * @var String

     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $startDate;

    /**
     * @var string
     * @Accessor(getter="getFormattedStartDate")
     * @Type(name="string")
     */
    protected $formattedStartDate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $endDate;

    /**
     * @var string
     * @Accessor(getter="getFormattedEndDate")
     * @Type(name="string")
     */
    protected $formattedEndDate;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Campaign
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Campaign
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Get formatted date
     *
     * @return string
     */
    public function getFormattedStartDate()
    {
        return $this->startDate ? $this->startDate->format($this->congregation->getSettings()->get('date_format_twig')->getValue()) : null;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Campaign
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Get formatted date
     *
     * @return string
     */
    public function getFormattedEndDate()
    {
        return $this->endDate ? $this->endDate->format($this->congregation->getSettings()->get('date_format_twig')->getValue()) : null;
    }

    /**
     * Set congregation
     *
     * @param Congregation $congregation
     * @return Campaign
     */
    public function setCongregation(Congregation $congregation = null)
    {
        $this->congregation = $congregation;

        return $this;
    }

    /**
     * Get congregation
     *
     * @return Congregation
     */
    public function getCongregation()
    {
        return $this->congregation;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        $now = new \DateTime();
        return $this->startDate < $now && $now < $this->endDate;
    }
}
