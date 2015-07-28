<?php

namespace KingdomHall\MainBundle\Controller;


use KingdomHall\DataBundle\Entity\Congregation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller {

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
        $form = $this->createForm('kingdomhall_form_congregation_settings', $congregation);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getEntityManager();
            $manager->persist($congregation);
            $manager->flush();
        }

        return array('form' => $form);
    }
}