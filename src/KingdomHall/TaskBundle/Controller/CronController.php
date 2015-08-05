<?php

namespace KingdomHall\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CronController extends Controller
{
    public function cronAction(Request $request)
    {
        $this->get('kingdomhall.service.cron')->runJobs();
        return new RedirectResponse($this->get('router')->generate('kingdom_hall_fallback'));
    }
}