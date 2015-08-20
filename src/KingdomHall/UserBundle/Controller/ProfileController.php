<?php

namespace KingdomHall\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as FOSProfileController;
use KingdomHall\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends FOSProfileController
{
    public function editAction()
    {
        $user = new User();
        $userId = $this->container->get('request')->get('userId');

        if ($userId) {
            $user = $this->container->get('doctrine.orm.entity_manager')->getRepository('KingdomHallUserBundle:User')->find($userId);
        } else {
            $user = $this->container->get('kingdomhall.user_manager')->createUser();
        }

        $form = $this->container->get('fos_user.profile.form');
        $formHandler = $this->container->get('fos_user.profile.form.handler');

        $process = $formHandler->process($user);

        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:Profile:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
            array(
                'form' => $form->createView(),
                'user' => $user,
            )
        );

    }
}