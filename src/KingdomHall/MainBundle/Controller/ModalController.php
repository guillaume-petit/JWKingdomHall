<?php

namespace KingdomHall\MainBundle\Controller;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\Common\Persistence\ManagerRegistry;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ModalController extends Controller
{
    /**
     * @param ParamFetcher $fetcher
     *
     * @QueryParam(name="header")
     * @QueryParam(name="message")
     *
     * @Template()
     *
     * @return array
     */
    public function confirmationModalAction(ParamFetcher $fetcher)
    {
        return array(
            'header' => $fetcher->get('header'),
            'message' => $fetcher->get('message'),
        );
    }

    /**
     * @param ParamFetcher $fetcher
     *
     * @QueryParam(name="header")
     * @QueryParam(name="message")
     *
     * @Template()
     *
     * @return array
     */
    public function infoModalAction(ParamFetcher $fetcher)
    {
        return array(
            'header' => $fetcher->get('header'),
            'message' => $fetcher->get('message'),
        );
    }

}
