<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/7/15
 * Time: 11:26 AM
 */

namespace KingdomHall\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class CongregationSettings
 * @package KingdomHall\DataBundle\Entity
 *
 * @Entity()
 * @ORM\Table(name="congregation_setting", uniqueConstraints={@UniqueConstraint(name="congregation_setting_idx", columns={"congregation_id", "code"})})
 * @UniqueEntity(fields={"congregation", "code"}, errorPath="code")
 */
class CongregationSetting {

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
     * @ORM\ManyToOne(targetEntity="KingdomHall\DataBundle\Entity\Congregation", inversedBy="settings")
     * @ORM\JoinColumn(name="congregation_id", referencedColumnName="id")
     */
    protected $congregation;

    /**
     * @var string
     * @ORM\Column(type="string", length=63, nullable=false)
     * @Assert\NotBlank()
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(type="string", length=63, nullable=false)
     * @Assert\NotBlank()
     */
    protected $code;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    protected $value;

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
     * Set type
     *
     * @param string $type
     * @return CongregationSetting
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
     * Set code
     *
     * @param string $code
     * @return CongregationSetting
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
     * Set value
     *
     * @param string $value
     * @return CongregationSetting
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set congregation
     *
     * @param \KingdomHall\DataBundle\Entity\Congregation $congregation
     * @return CongregationSetting
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
}
