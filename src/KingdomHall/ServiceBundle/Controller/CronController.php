<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 8/5/15
 * Time: 3:30 PM
 */

namespace KingdomHall\ServiceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CronController extends Controller
{
    public function notifyTerritoryAction(Request $request)
    {
        $this->get('kingdomhall.service.cron')->addJob('task.notify_territory');
        return new RedirectResponse($this->get('router')->generate('kingdom_hall_fallback'));
    }
}