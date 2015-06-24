<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/22/15
 * Time: 2:18 PM
 */

namespace KingdomHall\ServiceBundle\Service;


use Doctrine\ORM\EntityManager;
use KingdomHall\DataBundle\Entity\Congregation;

/**
 * Service related to Congregations
 *
 * @package KingdomHall\ServiceBundle\Service
 */
class CongregationService {

    /** @var EntityManager $em */
    protected $em;

    /**
     * @param EntityManager $em the entity manager
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Find congregation by code
     *
     * @param $congregationCode string the congregation code
     *
     * @return Congregation
     */
    public function findByCode($congregationCode)
    {
        return $this->em->getRepository('KingdomHallDataBundle:Congregation')->findOneBy(
            array ('code' => $congregationCode)
        );
    }

}