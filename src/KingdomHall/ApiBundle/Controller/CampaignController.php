<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/7/15
 * Time: 9:43 AM
 */

namespace KingdomHall\ApiBundle\Controller;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KingdomHall\DataBundle\Entity\Campaign;
use KingdomHall\DataBundle\Entity\Congregation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CampaignController
 * @package KingdomHall\ApiBundle\Controller
 */
class CampaignController extends FOSRestController {

    /**
     * @param Congregation          $congregation
     *
     * @View()
     * @ParamConverter(name="congregation", class="KingdomHallDataBundle:Congregation")
     *
     * @return array
     */
    public function getCongregationCampaignsAction(Congregation $congregation)
    {
        return $congregation->getCampaigns()->getValues();
    }

    /**
     * @Delete()
     *
     * @param Congregation $congregation
     * @param Campaign     $campaign
     *
     * @View()
     * @ParamConverter(name="congregation", class="KingdomHallDataBundle:Congregation")
     * @ParamConverter(name="campaign", class="KingdomHallDataBundle:Campaign")
     *
     * @return array
     */
    public function deleteCongregationCampaignAction(Congregation $congregation, Campaign $campaign)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($campaign);
        $manager->flush();

        return new Response('', 204);
    }

}