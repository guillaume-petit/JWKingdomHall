<?php

namespace KingdomHall\MainBundle\Controller\Admin;


use KingdomHall\DataBundle\Entity\Congregation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @param Congregation $congregation
     * @return array
     *
     * @Template()
     */
    public function listAction(Request $request, Congregation $congregation)
    {
        return array();
    }
}