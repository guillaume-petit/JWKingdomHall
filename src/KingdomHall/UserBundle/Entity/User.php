<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/1/15
 * Time: 3:42 PM
 */

namespace KingdomHall\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as FOSUser;
use KingdomHall\DataBundle\Entity\Publisher;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends FOSUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Publisher
     * @ORM\OneToOne(targetEntity="KingdomHall\DataBundle\Entity\Publisher", inversedBy="user")
     */
    protected $publisher;

    public function __construct()
    {
        parent::__construct();
    }

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
     * Set publisher
     *
     * @param \KingdomHall\DataBundle\Entity\Publisher $publisher
     * @return User
     */
    public function setPublisher(\KingdomHall\DataBundle\Entity\Publisher $publisher = null)
    {
        $this->publisher = $publisher;
        $publisher->setUser($this);

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
