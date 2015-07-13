<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/7/15
 * Time: 9:28 AM
 */

namespace KingdomHall\MainBundle\Controller\Territory;


use KingdomHall\DataBundle\Entity\Campaign;
use KingdomHall\DataBundle\Entity\Congregation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CampaignController extends Controller {

    /**
     * Index action, lists all territories
     *
     * @param Request      $request
     * @param Congregation $congregation
     * @return array
     *
     * @Template()
     */
    public function indexAction(Request $request, Congregation $congregation)
    {
        return array(
            'congregation' => $congregation,
        );
    }

    /**
     * @param Request      $request
     * @param Congregation $congregation
     *
     * @return array
     *
     * @Template()
     */
    public function newAction(Request $request, Congregation $congregation)
    {
        $campaign = new Campaign();
        $campaign->setCongregation($congregation);

        $form = $this->createForm(
            'kingdomhall_form_campaign',
            $campaign,
            array(
                'action' => $this->generateUrl(
                    'kingdom_hall_campaigns_new',
                    array (
                        'congregationCode' => $congregation->getCode()
                    )
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($campaign);
            $manager->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @param Request      $request
     * @param Congregation $congregation
     * @param Campaign     $campaign
     *
     * @ParamConverter(name="campaign", class="KingdomHallDataBundle:Campaign", options={"id" = "campaignId"})
     *
     * @return array
     *
     * @Template()
     */
    public function editAction(Request $request, Congregation $congregation, Campaign $campaign)
    {
        $form = $this->createForm(
            'kingdomhall_form_campaign',
            $campaign,
            array(
                'action' => $this->generateUrl(
                    'kingdom_hall_campaigns_edit',
                    array (
                        'congregationCode' => $congregation->getCode(),
                        'campaignId' => $campaign->getId(),
                    )
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($campaign);
            $manager->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }
}