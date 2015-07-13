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
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\Territory", mappedBy="congregation", indexBy="id")
     * @ORM\OrderBy({"number" = "ASC"})
     */
    protected $territories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\Publisher", mappedBy="congregation", indexBy="id")
     * @ORM\OrderBy({"lastName" = "ASC", "firstName" = "ASC"})
     */
    protected $publishers;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\Campaign", mappedBy="congregation", indexBy="id")
     * @ORM\OrderBy({"startDate" = "DESC"})
     */
    protected $campaigns;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="KingdomHall\DataBundle\Entity\CongregationSetting", mappedBy="congregation", indexBy="code")
     */
    protected $settings;

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
        $this->territories = new ArrayCollection();
    }

    /**
     * Add territories
     *
     * @param Territory $territories
     * @return Congregation
     */
    public function addTerritory(Territory $territories)
    {
        $this->territories[] = $territories;

        return $this;
    }

    /**
     * Remove territories
     *
     * @param Territory $territories
     */
    public function removeTerritory(Territory $territories)
    {
        $this->territories->removeElement($territories);
    }

    /**
     * Get territories
     *
     * @return ArrayCollection|Territory[]
     */
    public function getTerritories()
    {
        return $this->territories;
    }

    /**
     * @param $type
     * @return ArrayCollection
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
     * @param Publisher $publishers
     * @return Congregation
     */
    public function addPublisher(Publisher $publishers)
    {
        $this->publishers[] = $publishers;

        return $this;
    }

    /**
     * Remove publishers
     *
     * @param Publisher $publishers
     */
    public function removePublisher(Publisher $publishers)
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

    /**
     * Add campaigns
     *
     * @param Campaign $campaigns
     * @return Congregation
     */
    public function addCampaign(Campaign $campaigns)
    {
        $this->campaigns[] = $campaigns;

        return $this;
    }

    /**
     * Remove campaigns
     *
     * @param Campaign $campaigns
     */
    public function removeCampaign(Campaign $campaigns)
    {
        $this->campaigns->removeElement($campaigns);
    }

    /**
     * Get campaigns
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCampaigns()
    {
        return $this->campaigns;
    }

    /**
     * Add settings
     *
     * @param \KingdomHall\DataBundle\Entity\CongregationSetting $settings
     * @return Congregation
     */
    public function addSetting(\KingdomHall\DataBundle\Entity\CongregationSetting $settings)
    {
        $this->settings[] = $settings;

        return $this;
    }

    /**
     * Remove settings
     *
     * @param \KingdomHall\DataBundle\Entity\CongregationSetting $settings
     */
    public function removeSetting(\KingdomHall\DataBundle\Entity\CongregationSetting $settings)
    {
        $this->settings->removeElement($settings);
    }

    /**
     * Get settings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param string $code
     *
     * @return mixed the typed value
     */
    public function getTypedSetting($code)
    {
        $value = null;
        $setting = $this->getSettings()->get($code);
        if ($setting) {
            $value = $setting->getValue();
            settype($value, $setting->getType());
        }
        return $value;
    }

    /**
     * Get unexpired campaigns, that is ongoing and future campaigns.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnexpiredCampaigns()
    {
        return $this->campaigns->filter(function(Campaign $campaign) {
            $now = new \DateTime();
            return $now < $campaign->getEndDate();
        });
    }
}
