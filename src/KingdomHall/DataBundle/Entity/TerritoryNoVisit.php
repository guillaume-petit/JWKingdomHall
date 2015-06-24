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
use JMS\Serializer\Annotation\Type;

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
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Type("DateTime<'d/m/Y'>")
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
}
