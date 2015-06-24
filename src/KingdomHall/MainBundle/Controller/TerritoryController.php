<?php

namespace KingdomHall\MainBundle\Controller;

use KingdomHall\DataBundle\Entity\Congregation;
use KingdomHall\DataBundle\Entity\Territory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TerritoryController extends Controller
{
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
        $type = $request->get('type');

        $territory = new Territory();
        $territory->setCongregation($congregation);

        $form = $this->createForm('kingdomhall_form_territory', $territory);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($territory);
            $manager->flush();
        }

        return array(
            'congregation' => $congregation,
            'type' => $type ? $type : 'standard',
            'form' => $form->createView(),
        );
    }


    /**
     * @param Congregation $congregation
     * @param Territory    $territory
     *
     * @ParamConverter(name="territory", class="KingdomHallDataBundle:Territory", options={"id" = "territoryId"})
     *
     * @Template()
     *
     * @return array
     */
    public function editAction(Request $request, Congregation $congregation, Territory $territory)
    {
        $form = $this->createForm('kingdomhall_form_territory', $territory);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($territory);
            $manager->flush();
        }

        return array(
            'form'      => $form->createView(),
            'territory' => $territory,
        );
    }
}
