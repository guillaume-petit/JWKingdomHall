<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/28/15
 * Time: 3:43 PM
 */

namespace KingdomHall\ApiBundle\Controller;


use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use KingdomHall\DataBundle\Entity\Congregation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class PublisherController extends FOSRestController {

    /**
     * @param Congregation          $congregation
     *
     * @View()
     * @ParamConverter(name="congregation", class="KingdomHallDataBundle:Congregation")
     * @QueryParam(name="offset")
     * @QueryParam(name="limit")
     * @QueryParam(name="sort", default="lastName")
     * @QueryParam(name="order")
     * @QueryParam(name="search")
     *
     * @return array
     */
    public function getCongregationPublishersAction(Congregation $congregation, ParamFetcher $paramFetcher)
    {
        $pagination = array (
            'offset' => $paramFetcher->get('offset'),
            'limit' => $paramFetcher->get('limit'),
        );
        $sort = array (
            'sort' => $paramFetcher->get('sort'),
            'order' => $paramFetcher->get('order'),
        );
        $search = $paramFetcher->get('search');

        return $this->getDoctrine()->getRepository('KingdomHallDataBundle:Publisher')->searchPublisher($congregation, $pagination, $sort, $search);
    }

    /**
     * @Delete("/api/congregations/{congregation}/publishers")
     *
     * @param Congregation $congregation
     * @ParamConverter(name="congregation", class="KingdomHallDataBundle:Congregation")
     *
     * @param ParamFetcher $fetcher
     * @QueryParam("ids")
     *
     * @return string
     */
    public function deleteCongregationPublishersAction(Congregation $congregation, ParamFetcher $fetcher)
    {
        $manager = $this->getDoctrine()->getManager();

        $publishers = $congregation->getPublishers();
        foreach (explode(',', $fetcher->get('ids')) as $id) {
            $publisher = $publishers->get($id);
            if ($publisher) {
                $publisher->setDeleted(true);
                $manager->persist($publisher);
            }
        }

        $manager->flush();

        return new Response('', 204);
    }

}