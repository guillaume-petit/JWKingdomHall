<?php
namespace KingdomHall\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/21/15
 * Time: 4:21 PM
 */

/**
 * Class Builder
 *
 * Builder for the various menus of the site
 *
 * @package KingdomHall\MainBundle\Menu
 */
class Builder extends ContainerAware
{

    public function territoriesMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('jwkh.navbar.territories.title');
        $menu->setUri($this->container->get('request')->getRequestUri())
            ->setExtra('activeParent', true)
            ->setAttribute('class', 'nav navbar-nav navbar-left')
            ->setChildrenAttribute('class', 'dropdown-menu');

        $menu->addChild('jwkh.navbar.territories.list', array(
            'route' => 'kingdom_hall_territories_list',
            'routeParameters' => $this->container->get('request')->get('_route_params'),
            'label' => 'jwkh.navbar.territories.list',
        ));

        $menu->addChild('jwkh.navbar.territories.campaigns', array(
            'route' => 'kingdom_hall_campaigns_list',
            'routeParameters' => $this->container->get('request')->get('_route_params'),
            'label' => 'jwkh.navbar.territories.campaigns',
        ));

        return $menu;
    }

    public function publishersMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('jwkh.navbar.publishers', array(
            'route' => 'kingdom_hall_publishers_list',
            'routeParameters' => $this->container->get('request')->get('_route_params'),
            'label' => 'jwkh.navbar.publishers',
        ));

        return $menu;
    }

    public function settingsMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('jwkh.navbar.settings', array(
            'route' => 'kingdom_hall_settings',
            'routeParameters' => $this->container->get('request')->get('_route_params'),
            'label' => 'jwkh.navbar.settings',
        ));

        return $menu;
    }

    public function navbarMenu(FactoryInterface $factory, array $options)
    {
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $territories = $menu->addChild('jwkh.navbar.territories', array(
            'label' => 'jwkh.navbar.territories',
        ))
            ->setExtra('active-parent', true)
            ->setAttribute('class', 'nav navbar-nav')
            ->setChildrenAttribute('class', 'dropdown-menu');

        $menu->addChild('jwkh.navbar.publishers', array(
            'route' => 'kingdom_hall_publishers_list',
            'routeParameters' => $this->container->get('request')->get('_route_params'),
            'label' => 'jwkh.navbar.publishers',
        ));

        $menu->addChild('jwkh.navbar.settings', array(
            'route' => 'kingdom_hall_settings',
            'routeParameters' => $this->container->get('request')->get('_route_params'),
            'label' => 'jwkh.navbar.settings',
        ));

        return $menu;
    }

    /**
     * Returns the switch congregation menu on the top right corner
     *
     * @param FactoryInterface $factory
     * @param array $options
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function switchCongregationMenu(FactoryInterface $factory, array $options)
    {
        $routeParams = $this->container->get('request')->get('_route_params');
        $currentCongregation = $this->container->get('request')->get('congregation');
        $congregations = $this->container->get('doctrine')->getRepository('KingdomHallDataBundle:Congregation')->findAll();

        $menu = $factory->createItem($currentCongregation->getName());
        $menu
            ->setExtra('activeParent', false)
            ->setAttribute('class', 'nav navbar-nav navbar-right')
            ->setChildrenAttribute('class', 'dropdown-menu');


        foreach ($congregations as $congregation) {
            if ($currentCongregation != $congregation) {
                $routeParams['congregationCode'] = $congregation->getCode();
                $routeParams['_locale'] = $congregation->getDefaultLocale();
                $menu->addChild(
                    $congregation->getName(),
                    array(
                        'route' => 'kingdom_hall_homepage',
                        'routeParameters' => $routeParams,
                        'label' => $congregation->getName(),
                    )
                );
            }
        }
        return $menu;
    }

    /**
     * Left menu on the territories page
     *
     * @param FactoryInterface $factory
     * @param array $options
     *
     * @return \Knp\Menu\ItemInterface
     */
//    public function territoriesMenu(FactoryInterface $factory, array $options)
//    {
//        $menu = $factory->createItem('root');
//        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked');
//
//        $menu->addChild('jwkh.territories.menu.territories', array(
//            'route' => 'kingdom_hall_territories_list',
//            'routeParameters' => $this->container->get('request')->get('_route_params'),
//            'label' => 'jwkh.territories.menu.territories',
//        ));
//
//        $menu->addChild('jwkh.territories.menu.campaigns', array(
//            'route' => 'kingdom_hall_campaigns_list',
//            'routeParameters' => $this->container->get('request')->get('_route_params'),
//            'label' => 'jwkh.territories.menu.campaigns',
//        ));
//
//        return $menu;
//    }

}