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
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\SerializedName;
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
 * @ORM\Entity(repositoryClass="KingdomHall\DataBundle\Repository\TerritoryRepository")
 * @ORM\Table(name="territory", uniqueConstraints={@UniqueConstraint(name="territory_idx", columns={"congregation_id", "type", "number"})})
 * @UniqueEntity(fields={"congregation", "type", "number"}, errorPath="number")
 * @Uploadable()
 */
class Territory {

    const TERRITORY_TYPE_CAMPAIGN = 'campaign';
    const TERRITORY_TYPE_STANDARD = 'standard';
    const TERRITORY_STATUS_ALERT = 'danger';
    const TERRITORY_STATUS_WARNING = 'warning';

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
     * @Exclude()
     */
    protected $congregation;

    /**
     * @var Publisher
     * @ORM\ManyToOne(targetEntity="KingdomHall\DataBundle\Entity\Publisher", inversedBy="territories")
     * @ORM\JoinColumn(name="publisher_id", referencedColumnName="id")
     * @MaxDepth(depth=1)
     */
    protected $publisher;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\TerritoryHistory", mappedBy="territory", indexBy="id", cascade={"PERSIST", "REMOVE"})
     * @ORM\OrderBy({"borrowDate" = "ASC"})
     */
    protected $histories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\TerritoryNoVisit", mappedBy="territory", indexBy="id", cascade={"PERSIST", "REMOVE"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $noVisits;

    /**
     * @var integer
     * @ORM\Column(type="string", nullable=false, length=50)
     * @Assert\NotBlank()
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
     * @SerializedName("borrowDate")
     */
    protected $borrowDate;

    /**
     * @var string
     * @Accessor(getter="getFormattedBorrowDate")
     * @Type(name="string")
     * @SerializedName("formattedBorrowDate")
     */
    protected $formattedBorrowDate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     * @SerializedName("returnDate")
     */
    protected $returnDate;

    /**
     * @var string
     * @Accessor(getter="getFormattedReturnDate")
     * @Type(name="string")
     * @SerializedName("formattedReturnDate")
     */
    protected $formattedReturnDate;

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
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $phone;

    /**
     * @var string
     * @Accessor(getter="getStatus")
     * @Type(name="string")
     */
    protected $status;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $excludedLanguages;

    /**
     * @var string
     * @ORM\Column(type="string", length=15)
     */
    protected $notified;

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
     * @param Congregation $congregation
     * @return Territory
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
     * @param Publisher $publisher
     * @return Territory
     */
    public function setPublisher(Publisher $publisher = null)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return Publisher
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
     * Get formatted date
     *
     * @return string
     */
    public function getFormattedBorrowDate()
    {
        return $this->borrowDate ? $this->borrowDate->format($this->congregation->getSettings()->get('date_format_twig')->getValue()) : null;
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
     * Get formatted date
     *
     * @return string
     */
    public function getFormattedReturnDate()
    {
        return $this->returnDate ? $this->returnDate->format($this->congregation->getSettings()->get('date_format_twig')->getValue()) : null;
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
        $this->histories = new ArrayCollection();
    }

    /**
     * Add histories
     *
     * @param TerritoryHistory $histories
     * @return Territory
     */
    public function addHistory(TerritoryHistory $histories)
    {
        $this->histories[] = $histories;
        $histories->setTerritory($this);
        return $this;
    }

    /**
     * Remove histories
     *
     * @param TerritoryHistory $histories
     */
    public function removeHistory(TerritoryHistory $histories)
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
     * @param TerritoryNoVisit $noVisits
     * @return Territory
     */
    public function addNoVisit(TerritoryNoVisit $noVisits)
    {
        $this->noVisits[] = $noVisits;
        $noVisits->setTerritory($this);

        return $this;
    }

    /**
     * Remove noVisits
     *
     * @param TerritoryNoVisit $noVisits
     */
    public function removeNoVisit(TerritoryNoVisit $noVisits)
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

    /**
     * Set phone
     *
     * @param boolean $phone
     * @return Territory
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return boolean 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Checks if the territory is available for borrow
     *
     * @return bool
     */
    public function isAvailable()
    {
        $currentCampaigns = $this->congregation->getUnexpiredCampaigns();
        return  $this->type == self::TERRITORY_TYPE_STANDARD ||
                ($this->type == self::TERRITORY_TYPE_CAMPAIGN &&                    // Check if this is a campaign territory
                !$currentCampaigns->isEmpty() &&                                   // Check if a campaign is currently ongoing or planned in the future
                $this->returnDate < $currentCampaigns->first()->getStartDate());    // Check if the territory has already been worked during the campaign
    }

    public function getStatus()
    {
        $status = '';
        if ($this->publisher) {
            $warningDate = new \DateTime();
            $warningDate->add(\DateInterval::createFromDateString('-'.$this->congregation->getSettings()->get('territory_warning_borrow_time')->getValue()));
            $alertDate = new \DateTime();
            $alertDate->add(\DateInterval::createFromDateString('-'.$this->congregation->getSettings()->get('territory_max_borrow_time')->getValue()));
            if ($this->borrowDate) {
                if ($this->borrowDate < $alertDate) {
                    $status = self::TERRITORY_STATUS_ALERT;
                } elseif ($this->borrowDate < $warningDate) {
                    $status = self::TERRITORY_STATUS_WARNING;
                }
            }
        }
        return $status;
    }

    /**
     * Set excludedLanguages
     *
     * @param string $excludedLanguages
     * @return Territory
     */
    public function setExcludedLanguages($excludedLanguages)
    {
        $this->excludedLanguages = $excludedLanguages;

        return $this;
    }

    /**
     * Get excludedLanguages
     *
     * @return string 
     */
    public function getExcludedLanguages()
    {
        return $this->excludedLanguages;
    }

    /**
     * Set notified
     *
     * @param string $notified
     * @return Territory
     */
    public function setNotified($notified)
    {
        $this->notified = $notified;

        return $this;
    }

    /**
     * Get notified
     *
     * @return string
     */
    public function getNotified()
    {
        return $this->notified;
    }
}
