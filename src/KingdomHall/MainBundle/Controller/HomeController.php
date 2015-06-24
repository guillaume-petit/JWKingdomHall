<?php

namespace KingdomHall\MainBundle\Controller;

use KingdomHall\DataBundle\Entity\Congregation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{

    /**
     * @param Congregation $congregation
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Template()
     */
    public function indexAction(Congregation $congregation)
    {
        return array();
    }
}
