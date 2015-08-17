<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 8/10/15
 * Time: 3:27 PM
 */

namespace KingdomHall\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as FOSRegistrationController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegistrationController extends FOSRegistrationController
{
    public function registerAction()
    {
        $token = $this->container->get('request')->get('token');
        $user = null;
        if ($token) {
            $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        }

        if ($user === null) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        $form = $this->container->get('fos_user.registration.form');
        $form->setData($user);
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            if ($authUser) {
                $this->authenticateUser($user, $response);
            }

            return $response;
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.'.$this->getEngine(), array(
            'form' => $form->createView(),
        ));
    }
}