<?php

namespace KingdomHall\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Request\ParamFetcherInterface;
use KingdomHall\DataBundle\Entity\Congregation;
use KingdomHall\DataBundle\Entity\Territory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package KingdomHall\ApiBundle\Controller
 */
class TerritoryController extends FOSRestController
{
    /**
     * @param Congregation          $congregation
     * @param ParamFetcherInterface $paramFetcher
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

    /**
     * @param Congregation $congregation
     * @ParamConverter(name="congregation", class="KingdomHallDataBundle:Congregation")
     *
     * @param Territory    $territory
     * @ParamConverter(name="territory", class="KingdomHallDataBundle:Territory")
     *
     * @View()
     *
     * @return array
     */
    public function getCongregationTerritoryNoVisitsAction(Congregation $congregation, Territory $territory)
    {
        return $territory->getNoVisits();
    }

    /**
     * @Delete("/api/congregations/{congregation}/territories")
     *
     * @param Congregation $congregation
     * @ParamConverter(name="congregation", class="KingdomHallDataBundle:Congregation")
     *
     * @param ParamFetcher $fetcher
     * @QueryParam("ids")
     *
     * @return string
     */
    public function deleteCongregationTerritoriesAction(Congregation $congregation, ParamFetcher $fetcher)
    {
        $manager = $this->getDoctrine()->getManager();

        $territories = $congregation->getTerritories();
        foreach (explode(',', $fetcher->get('ids')) as $id) {
            $territory = $territories->get($id);
            if ($territory) {
                $manager->remove($territory);
            }
        }

        $manager->flush();

        return new Response('', 204);
    }

    /**
     * @Delete("/api/congregations/{congregation}/territories/{territory}/novisits")
     *
     * @param Congregation $congregation
     * @ParamConverter(name="congregation", class="KingdomHallDataBundle:Congregation")
     *
     * @param Territory $territory
     * @ParamConverter(name="territory", class="KingdomHallDataBundle:Territory")
     *
     * @param ParamFetcher $fetcher
     * @QueryParam("ids")
     *
     * @return string
     */
    public function deleteCongregationTerritoryNoVisitsAction(Congregation $congregation, Territory $territory, ParamFetcher $fetcher)
    {
        $manager = $this->getDoctrine()->getManager();

        $noVisits = $territory->getNoVisits();
        foreach (explode(',', $fetcher->get('ids')) as $id) {
            $noVisit = $noVisits->get($id);
            if ($noVisit) {
                $manager->remove($noVisit);
            }
        }

        $manager->flush();

        return new Response('', 204);
    }

}
