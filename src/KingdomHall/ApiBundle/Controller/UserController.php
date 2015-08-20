<?php

namespace KingdomHall\ApiBundle\Controller;


use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;

class UserController extends FOSRestController
{

    /**
     * @View()
     * @QueryParam(name="offset")
     * @QueryParam(name="limit")
     * @QueryParam(name="sort", default="username")
     * @QueryParam(name="order")
     * @QueryParam(name="search")
     *
     * @return array
     */
    public function getUsersAction(ParamFetcher $paramFetcher)
    {
        $pagination = array (
            'offset' => $paramFetcher->get('offset'),
            'limit' => $paramFetcher->get('limit'),
        );
        $sort = array (
            'sort' => $paramFetcher->get('sort'),
            'order' => $paramFetcher->get('order'),
        );
        $search = $paramFetcher->get('search');

        return $this->get('kingdomhall.user_manager')->searchUser($pagination, $sort, $search);
    }

    /**
     * @View
     * @param $id
     */
    public function deleteUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository('KingdomHallUserBundle:User')->find($id);
        $user->getPublisher()->setUser(null);
        $this->get('kingdomhall.user_manager')->deleteUser($user);
    }
}