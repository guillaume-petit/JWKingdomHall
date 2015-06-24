<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/22/15
 * Time: 4:05 PM
 */

namespace KingdomHall\DataBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Territory
 * @package KingdomHall\DataBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="territory")
 * @UniqueEntity("number")
 */
class Territory {

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
     * @ORM\ManyToOne(targetEntity="KingdomHall\DataBundle\Entity\Congregation", inversedBy="territories")
     * @ORM\JoinColumn(name="congregation_id", referencedColumnName="id")
     */
    protected $congregation;

    /**
     * @var Publisher
     * @ORM\ManyToOne(targetEntity="KingdomHall\DataBundle\Entity\Publisher", inversedBy="territories")
     * @ORM\JoinColumn(name="publisher_id", referencedColumnName="id", nullable=true)
     */
    protected $publisher;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     */
    protected $number;

    /**
     * @var string
     * @ORM\Column(type="string", length=63, nullable=false)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=15, nullable=false)
     * @Assert\NotBlank()
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    protected $area;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     * @Type("DateTime<'d/m/Y'>")
     */
    protected $borrowDate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     * @Type("DateTime<'d/m/Y'>")
     */
    protected $returnDate;

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
     * Set number
     *
     * @param integer $number
     * @return Territory
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Territory
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
     * Set type
     *
     * @param string $type
     * @return Territory
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set congregation
     *
     * @param \KingdomHall\DataBundle\Entity\Congregation $congregation
     * @return Territory
     */
    public function setCongregation(\KingdomHall\DataBundle\Entity\Congregation $congregation = null)
    {
        $this->congregation = $congregation;

        return $this;
    }

    /**
     * Get congregation
     *
     * @return \KingdomHall\DataBundle\Entity\Congregation 
     */
    public function getCongregation()
    {
        return $this->congregation;
    }

    /**
     * Set area
     *
     * @param string $area
     * @return Territory
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set publisher
     *
     * @param \KingdomHall\DataBundle\Entity\Publisher $publisher
     * @return Territory
     */
    public function setPublisher(\KingdomHall\DataBundle\Entity\Publisher $publisher = null)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return \KingdomHall\DataBundle\Entity\Publisher 
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set borrowDate
     *
     * @param \DateTime $borrowDate
     * @return Territory
     */
    public function setBorrowDate($borrowDate)
    {
        $this->borrowDate = $borrowDate;

        return $this;
    }

    /**
     * Get borrowDate
     *
     * @return \DateTime 
     */
    public function getBorrowDate()
    {
        return $this->borrowDate;
    }

    /**
     * Set returnDate
     *
     * @param \DateTime $returnDate
     * @return Territory
     */
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    /**
     * Get returnDate
     *
     * @return \DateTime 
     */
    public function getReturnDate()
    {
        return $this->returnDate;
    }
}
