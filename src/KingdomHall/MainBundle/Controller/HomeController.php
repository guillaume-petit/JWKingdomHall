<?php

namespace KingdomHall\MainBundle\Controller;

use KingdomHall\DataBundle\Entity\Congregation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        return array(
            'congregation' => $congregation,
        );
    }
}
