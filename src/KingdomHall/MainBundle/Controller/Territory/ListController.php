<?php

namespace KingdomHall\MainBundle\Controller\Territory;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\Common\Persistence\ManagerRegistry;
use KingdomHall\DataBundle\Entity\Congregation;
use KingdomHall\DataBundle\Entity\Territory;
use KingdomHall\DataBundle\Entity\TerritoryHistory;
use KingdomHall\DataBundle\Entity\TerritoryNoVisit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListController extends Controller
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

        return array(
            'congregation' => $congregation,
            'type' => $type ? $type : 'standard',
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
        $territory = new Territory();
        $territory->setCongregation($congregation);

        $form = $this->createForm(
            'kingdomhall_form_territory',
            $territory,
            array(
                'action' => $this->generateUrl(
                    'kingdom_hall_territories_new',
                    array (
                        'congregationCode' => $congregation->getCode()
                    )
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($territory);
            $manager->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @param Request      $request
     * @param Congregation $congregation
     * @param Territory    $territory
     *
     * @ParamConverter(name="territory", class="KingdomHallDataBundle:Territory", options={"id" = "territoryId"})
     *
     * @return array
     *
     * @Template()
     */
    public function editAction(Request $request, Congregation $congregation, Territory $territory)
    {
        $form = $this->createForm(
            'kingdomhall_form_territory',
            $territory,
            array(
                'action' => $this->generateUrl(
                    'kingdom_hall_territories_edit',
                    array (
                        'congregationCode' => $congregation->getCode(),
                        'territoryId' => $territory->getId(),
                    )
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($territory);
            $manager->flush();
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @param Request      $request
     * @param Congregation $congregation
     * @param Territory    $territory
     *
     * @ParamConverter(name="territory", class="KingdomHallDataBundle:Territory", options={"id" = "territoryId"})
     *
     * @Template()
     *
     * @return array
     */
    public function viewAction(Request $request, Congregation $congregation, Territory $territory)
    {
        return array(
            'territory' => $territory,
        );
    }

    /**
     * @param Request      $request
     * @param Congregation $congregation
     * @param Territory    $territory
     *
     * @ParamConverter(name="territory", class="KingdomHallDataBundle:Territory", options={"id" = "territoryId"})
     *
     * @return array
     *
     * @Template()
     */
    public function borrowAction(Request $request, Congregation $congregation, Territory $territory)
    {
        $form = $this->createForm(
            'kingdomhall_form_borrow_territory',
            $territory,
            array(
                'action' => $this->generateUrl(
                    'kingdom_hall_territories_borrow',
                    array (
                        'congregationCode' => $congregation->getCode(),
                        'territoryId' => $territory->getId(),
                    )
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $history = new TerritoryHistory();
            $history
                ->setPublisher($territory->getPublisher())
                ->setBorrowDate($territory->getBorrowDate());
            $territory->addHistory($history);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($territory);
            $manager->flush();
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @param Request      $request
     * @param Congregation $congregation
     * @param Territory    $territory
     *
     * @ParamConverter(name="territory", class="KingdomHallDataBundle:Territory", options={"id" = "territoryId"})
     *
     * @return array
     *
     * @Template()
     */
    public function returnAction(Request $request, Congregation $congregation, Territory $territory)
    {
        $form = $this->createForm(
            'kingdomhall_form_return_territory',
            $territory,
            array(
                'action' => $this->generateUrl(
                    'kingdom_hall_territories_return',
                    array (
                        'congregationCode' => $congregation->getCode(),
                        'territoryId' => $territory->getId(),
                    )
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $history = $territory->getHistories()->first();
            $worked = $form->get('worked')->getData();

            if (!$worked) {
                $territory->removeHistory($history);
                $manager->remove($history);
            } else {
                $history->setReturnDate($territory->getReturnDate());
                $manager->persist($history);
            }

            $territory
                ->setPublisher(null)
                ->setBorrowDate(null);
            $manager->persist($territory);

            $manager->flush();
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @param Request      $request
     * @param Congregation $congregation
     * @param Territory    $territory
     *
     * @ParamConverter(name="territory", class="KingdomHallDataBundle:Territory", options={"id" = "territoryId"})
     *
     * @return array
     *
     * @Template()
     */
    public function newNoVisitAction(Request $request, Congregation $congregation, Territory $territory)
    {
        $noVisit = new TerritoryNoVisit();
        $noVisit->setTerritory($territory);

        $form = $this->createForm(
            'kingdomhall_form_territory_no_visit',
            $noVisit,
            array(
                'action' => $this->generateUrl(
                    'kingdom_hall_territories_novisit_new',
                    array (
                        'congregationCode' => $congregation->getCode(),
                        'territoryId' => $territory->getId(),
                    )
                )
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $territory->addNoVisit($noVisit);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($territory);
            $manager->flush();
        }

        return array(
            'form' => $form->createView()
        );
    }
}
