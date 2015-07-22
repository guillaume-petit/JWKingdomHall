<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/22/15
 * Time: 9:36 AM
 */

namespace KingdomHall\MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class FallbackController extends Controller {

    public function fallbackAction(Request $request)
    {
        $locale = $request->get('_locale');

        $congregation = $this->get('kingdomhall.service.congregation')->getFirst();

        $url = $this->get('router')->generate('kingdom_hall_homepage', array (
            'congregationCode' => $congregation->getCode(),
            '_locale' => $locale ? $locale : $congregation->getDefaultLocale(),
        ));

        return new RedirectResponse($url);
    }
}