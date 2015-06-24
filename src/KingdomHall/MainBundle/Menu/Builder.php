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
class Builder extends ContainerAware {

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
                        'route' => $this->container->get('request')->get('_route'),
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
    public function territoriesMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked');
        $menu->addChild('jwkh.territories.menu.territories', array(
            'route' => 'kingdom_hall_territories_list',
            'routeParameters' => $this->container->get('request')->get('_route_params'),
            'label' => 'jwkh.territories.menu.territories',
        ));

        return $menu;
    }

}