<?php

namespace KingdomHall\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KingdomHallUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
