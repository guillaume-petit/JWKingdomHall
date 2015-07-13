<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/24/15
 * Time: 4:53 PM
 */

namespace KingdomHall\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TerritoryNoVisit
 * @package KingdomHall\DataBundle\Entity
 *
 * @Entity()
 */
class TerritoryNoVisit {

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
     * @ORM\ManyToOne(targetEntity="KingdomHall\DataBundle\Entity\Territory", inversedBy="noVisits")
     * @ORM\JoinColumn(name="territory_id", referencedColumnName="id")
     */
    protected $territory;

    /**
     * @var Publisher
     * @ORM\ManyToOne(targetEntity="KingdomHall\DataBundle\Entity\Publisher")
     * @ORM\JoinColumn(name="publisher_id", referencedColumnName="id")
     */
    protected $publisher;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $address;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    protected $date;

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
     * @return TerritoryNoVisit
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
     * Set date
     *
     * @param \DateTime $date
     * @return TerritoryNoVisit
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set territory
     *
     * @param \KingdomHall\DataBundle\Entity\Territory $territory
     * @return TerritoryNoVisit
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
     * Set address
     *
     * @param string $address
     * @return TerritoryNoVisit
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set publisher
     *
     * @param \KingdomHall\DataBundle\Entity\Publisher $publisher
     * @return TerritoryNoVisit
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
}
