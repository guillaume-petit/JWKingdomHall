<?php

namespace KingdomHall\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use KingdomHall\DataBundle\Entity\Congregation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class DefaultController
 * @package KingdomHall\ApiBundle\Controller
 */
class TerritoryController extends FOSRestController
{
    /**
     * @param Congregation $congregation
     *
     * @View()
     * @QueryParam(name="type")
     * @ParamConverter(name="congregation", class="KingdomHallDataBundle:Congregation")
     *
     * @return array
     */
    public function getCongregationTerritoriesAction($congregation, ParamFetcherInterface $paramFetcher)
    {
        return $congregation->getTerritoriesByType($paramFetcher->get('type'))->getValues();
    }

}
