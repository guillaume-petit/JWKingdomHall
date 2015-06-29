<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/22/15
 * Time: 4:05 PM
 */

namespace KingdomHall\DataBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JMS\Serializer\Annotation\Type;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * Class Territory
 * @package KingdomHall\DataBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="territory", uniqueConstraints={@UniqueConstraint(name="territory_idx", columns={"congregation_id", "type", "number"})})
 * @UniqueEntity(fields={"congregation", "type", "number"}, errorPath="number")
 * @Uploadable()
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
     * @ORM\JoinColumn(name="publisher_id", referencedColumnName="id")
     */
    protected $publisher;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\TerritoryHistory", mappedBy="territory", cascade={"PERSIST"})
     * @ORM\OrderBy({"borrowDate" = "DESC"})
     */
    protected $histories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\TerritoryNoVisit", mappedBy="territory", cascade={"PERSIST"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $noVisits;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
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
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $mapName;

    /**
     * @var UploadedFile
     * @UploadableField(mapping="territory_map", fileNameProperty="mapName")
     */
    protected $mapFile;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @return UploadedFile
     */
    public function getMapFile()
    {
        return $this->mapFile;
    }

    /**
     * @param UploadedFile $mapFile
     */
    public function setMapFile($mapFile)
    {
        $this->mapFile = $mapFile;

        if ($mapFile) {
            $this->updatedAt = new \DateTime();
        }
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

    /**
     * Set mapName
     *
     * @param string $mapName
     * @return Territory
     */
    public function setMapName($mapName)
    {
        $this->mapName = $mapName;

        return $this;
    }

    /**
     * Get mapName
     *
     * @return string 
     */
    public function getMapName()
    {
        return $this->mapName;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->histories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add histories
     *
     * @param \KingdomHall\DataBundle\Entity\TerritoryHistory $histories
     * @return Territory
     */
    public function addHistory(\KingdomHall\DataBundle\Entity\TerritoryHistory $histories)
    {
        $this->histories[] = $histories;
        $histories->setTerritory($this);
        return $this;
    }

    /**
     * Remove histories
     *
     * @param \KingdomHall\DataBundle\Entity\TerritoryHistory $histories
     */
    public function removeHistory(\KingdomHall\DataBundle\Entity\TerritoryHistory $histories)
    {
        $this->histories->removeElement($histories);
    }

    /**
     * Get histories
     *
     * @return ArrayCollection|TerritoryHistory[]
     */
    public function getHistories()
    {
        return $this->histories;
    }

    /**
     * Add noVisits
     *
     * @param \KingdomHall\DataBundle\Entity\TerritoryNoVisit $noVisits
     * @return Territory
     */
    public function addNoVisit(\KingdomHall\DataBundle\Entity\TerritoryNoVisit $noVisits)
    {
        $this->noVisits[] = $noVisits;
        $noVisits->setTerritory($this);

        return $this;
    }

    /**
     * Remove noVisits
     *
     * @param \KingdomHall\DataBundle\Entity\TerritoryNoVisit $noVisits
     */
    public function removeNoVisit(\KingdomHall\DataBundle\Entity\TerritoryNoVisit $noVisits)
    {
        $this->noVisits->removeElement($noVisits);
    }

    /**
     * Get noVisits
     *
     * @return TerritoryNoVisit[]
     */
    public function getNoVisits()
    {
        return $this->noVisits;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Territory
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
