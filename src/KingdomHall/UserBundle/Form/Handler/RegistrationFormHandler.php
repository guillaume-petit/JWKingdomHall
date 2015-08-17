<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 8/11/15
 * Time: 9:35 AM
 */

namespace KingdomHall\UserBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as FOSRegistrationFormHandler;

class RegistrationFormHandler extends FOSRegistrationFormHandler
{
    public function process($confirmation = false)
    {
        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($user, $confirmation);

                return true;
            }
        }

        return false;
    }
}