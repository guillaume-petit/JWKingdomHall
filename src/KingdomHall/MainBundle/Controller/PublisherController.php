<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/28/15
 * Time: 3:36 PM
 */

namespace KingdomHall\MainBundle\Controller;


use KingdomHall\DataBundle\Entity\Congregation;
use KingdomHall\DataBundle\Entity\Publisher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PublisherController extends Controller {

    /**
     * @param Request $request
     * @param Congregation $congregation
     *
     * @Template()
     * @return array
     */
    public function listAction(Request $request, Congregation $congregation)
    {
        return array();
    }

    /**
     * @param Request $request
     * @param Congregation $congregation
     * @param Publisher $publisher
     *
     * @ParamConverter(name="publisher", class="KingdomHallDataBundle:Publisher", isOptional="true", options={"id" = "publisherId"})
     *
     * @Template()
     * @return array
     */
    public function editAction(Request $request, Congregation $congregation, Publisher $publisher = null)
    {
        if (!$publisher) {
            $publisher = new Publisher();
            $publisher->setCongregation($congregation);
        }

        $id = $publisher->getId();

        $form = $this->createForm(
            'kingdomhall_form_publisher',
            $publisher,
            array(
                'action' => $this->generateUrl(
                    'kingdom_hall_publishers_edit',
                    array (
                        'congregationCode' => $congregation->getCode(),
                        'publisherId' => $id ? $id : 0,
                    )
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getEntityManager();
            $manager->persist($publisher);
            $manager->flush();
        }

        return array (
            'form' => $form->createView(),
        );
    }
}