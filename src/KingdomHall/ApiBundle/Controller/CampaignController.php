<?php
namespace KingdomHall\ApiBundle\Controller;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use KingdomHall\DataBundle\Entity\Campaign;
use KingdomHall\DataBundle\Entity\Congregation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package KingdomHall\ApiBundle\Controller
 *
 * API for campaigns
 *
 */
class CampaignController extends FOSRestController {

    /**
     * Get all the campaigns associated to a congregation.
     *
     * @param Congregation $congregation a congregation
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
     * Delete a campaign from a congregation
     *
     * @Delete()
     *
     * @param Congregation $congregation a congregation
     * @param Campaign     $campaign     a campaign
     *
     * @View()
     * @ParamConverter(name="congregation", class="KingdomHallDataBundle:Congregation")
     * @ParamConverter(name="campaign", class="KingdomHallDataBundle:Campaign")
     *
     * @return Response
     */
    public function deleteCongregationCampaignAction(Congregation $congregation, Campaign $campaign)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($campaign);
        $manager->flush();

        return new Response('', 204);
    }

}