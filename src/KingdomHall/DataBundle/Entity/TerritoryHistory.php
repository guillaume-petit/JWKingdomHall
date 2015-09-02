<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/24/15
 * Time: 4:11 PM
 */

namespace KingdomHall\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use JMS\Serializer\Annotation\Exclude;

/**
 * Class TerritoryHistory
 * @package KingdomHall\DataBundle\Entity
 *
 * @Entity()
 */
class TerritoryHistory {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Territory
     * @ORM\ManyToOne(targetEntity="KingdomHall\DataBundle\Entity\Territory", inversedBy="histories")
     * @ORM\JoinColumn(name="territory_id", referencedColumnName="id")
     * @Exclude()
     */
    protected $territory;

    /**
     * @var Publisher
     * @ORM\ManyToOne(targetEntity="KingdomHall\DataBundle\Entity\Publisher")
     * @ORM\JoinColumn(name="publisher_id", referencedColumnName="id")
     */
    protected $publisher;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $borrowDate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
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
     * Set borrowDate
     *
     * @param \DateTime $borrowDate
     * @return TerritoryHistory
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
     * @return TerritoryHistory
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

    /**
     * Set territory
     *
     * @param \KingdomHall\DataBundle\Entity\Territory $territory
     * @return TerritoryHistory
     */
    public function setTerritory(\KingdomHall\DataBundle\Entity\Territory $territory = null)
    {
        $this->territory = $territory;

        return $this;
    }

    /**
     * Get territory
     *
     * @return \KingdomHall\DataBundle\Entity\Territory 
     */
    public function getTerritory()
    {
        return $this->territory;
    }

    /**
     * Set publisher
     *
     * @param \KingdomHall\DataBundle\Entity\Publisher $publisher
     * @return TerritoryHistory
     */
    public function setPublisher(Publisher $publisher = null)
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
}
