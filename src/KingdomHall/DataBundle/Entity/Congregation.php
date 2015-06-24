<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/22/15
 * Time: 9:51 AM
 */

namespace KingdomHall\DataBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Congregation
 * @package KingdomHall\DataBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="congregation")
 */
class Congregation {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=7)
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=63)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=7)
     */
    protected $defaultLocale;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\Territory", mappedBy="congregation")
     * @ORM\OrderBy({"number" = "ASC"})
     */
    protected $territories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\Publisher", mappedBy="congregation")
     */
    protected $publishers;

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
     * Set code
     *
     * @param string $code
     * @return Congregation
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Congregation
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
     * Set defaultLocale
     *
     * @param string $defaultLocale
     * @return Congregation
     */
    public function setDefaultLocale($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;

        return $this;
    }

    /**
     * Get defaultLocale
     *
     * @return string 
     */
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->territories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add territories
     *
     * @param \KingdomHall\DataBundle\Entity\Territory $territories
     * @return Congregation
     */
    public function addTerritory(\KingdomHall\DataBundle\Entity\Territory $territories)
    {
        $this->territories[] = $territories;

        return $this;
    }

    /**
     * Remove territories
     *
     * @param \KingdomHall\DataBundle\Entity\Territory $territories
     */
    public function removeTerritory(\KingdomHall\DataBundle\Entity\Territory $territories)
    {
        $this->territories->removeElement($territories);
    }

    /**
     * Get territories
     *
     * @return Territory[]
     */
    public function getTerritories()
    {
        return $this->territories;
    }

    /**
     * @param $type
     * @return Territory[]
     */
    public function getTerritoriesByType($type)
    {
        return $this->territories->filter(function (Territory $territory) use ($type) {
            return $territory->getType() == $type;
        });
    }

    /**
     * Add publishers
     *
     * @param \KingdomHall\DataBundle\Entity\Publisher $publishers
     * @return Congregation
     */
    public function addPublisher(\KingdomHall\DataBundle\Entity\Publisher $publishers)
    {
        $this->publishers[] = $publishers;

        return $this;
    }

    /**
     * Remove publishers
     *
     * @param \KingdomHall\DataBundle\Entity\Publisher $publishers
     */
    public function removePublisher(\KingdomHall\DataBundle\Entity\Publisher $publishers)
    {
        $this->publishers->removeElement($publishers);
    }

    /**
     * Get publishers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPublishers()
    {
        return $this->publishers;
    }
}
