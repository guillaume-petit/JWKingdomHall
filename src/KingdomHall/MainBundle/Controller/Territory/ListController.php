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
use Symfony\Component\HttpFoundation\Response;

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
            if ($worked == 'no') {
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
     * @param Request          $request
     * @param Congregation     $congregation
     * @param Territory        $territory
     * @param TerritoryNoVisit $noVisit
     *
     * @ParamConverter(name="territory", class="KingdomHallDataBundle:Territory", options={"id" = "territoryId"})
     * @ParamConverter(name="noVisit", isOptional=true, class="KingdomHallDataBundle:TerritoryNoVisit", options={"id" = "noVisitId"})
     *
     * @return array
     *
     * @Template()
     */
    public function editNoVisitAction(Request $request, Congregation $congregation, Territory $territory, TerritoryNoVisit $noVisit = null)
    {
        if (!$noVisit) {
            $noVisit = new TerritoryNoVisit();
            $noVisit->setTerritory($territory);
        }

        $id = $noVisit->getId();

        $form = $this->createForm(
            'kingdomhall_form_territory_no_visit',
            $noVisit,
            array(
                'action' => $this->generateUrl(
                    'kingdom_hall_territories_novisit_edit',
                    array (
                        'congregationCode' => $congregation->getCode(),
                        'territoryId' => $territory->getId(),
                        'noVisitId' => $id ? $id : 0,
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

    /**
     * @param Request      $request
     * @param Congregation $congregation
     *
     * @Template()
     *
     * @return array
     */
    public function s13Action(Request $request, Congregation $congregation)
    {
        $page = $request->get('page');

        $territories = $this->getDoctrine()->getRepository('KingdomHallDataBundle:Territory')->searchTerritories(
            $congregation,
            'standard',
            array(
                'limit' => 5,
                'offset' => $page * 5,
            ),
            array (
                'sort' =>'number',
                'order' => 'ASC',
            )
        );

        return array (
            'congregation' => $congregation,
            'territories' => $territories
        );
    }

    /**
     * @param Request $request
     * @param Congregation $congregation
     *
     * @return Response
     */
    public function s13PdfAction(Request $request, Congregation $congregation)
    {
        $territories = $congregation->getTerritoriesByType('standard')->getValues();

        $pdfData = array();

        $page = 0;
        while ($page < count($territories) / 5) {
            $pdfData[$page]['body'] = array();
            for ($i = 0; $i < 5; $i++) {
                if (array_key_exists($page * 5 + $i, $territories)) {
                    $territory = $territories[$page * 5 + $i];
                    $pdfData[$page]['header'][$i] = array(
                        'name' => $territory->getName(),
                        'number' => $territory->getNumber(),
                    );
                    $row = 0;
                    foreach ($territory->getHistories() as $history) {
                        $pdfData[$page]['body'][$row][$i] = array(
                            'name' => $history->getPublisher()->getFullName(),
                            'borrow' => $history->getBorrowDate(),
                            'return' => $history->getReturnDate(),
                        );
                        $row++;
                    }
                }
            }
            $page++;
        }

        $html = $this->render(
            '@KingdomHallMain/Territory/List/s13Pdf.html.twig',
            array(
                'data' => $pdfData,
            )
        );

        $mpdf = new \mPDF();
        $mpdf->ignore_invalid_utf8 = true;
        $mpdf->WriteHTML($html);
        $pdf = $mpdf->Output($congregation->getName() . '_s13.pdf', 'I');

        return new Response($pdf, 200, array (
            'Content-Type' => 'application/pdf',
        ));
    }
}
