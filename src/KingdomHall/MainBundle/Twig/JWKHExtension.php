<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/7/15
 * Time: 2:47 PM
 */

namespace KingdomHall\MainBundle\Twig;


use KingdomHall\DataBundle\Entity\Congregation;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class JWKHExtension extends \Twig_Extension
{

    /** @var  Congregation */
    protected $congregation;

    public function __construct(Container $container)
    {
        $this->congregation = $container->get('request')->get('congregation');
    }

    public function getFilters()
    {
        return array (
            new \Twig_SimpleFilter('congregation_setting', array ($this, 'getCongregationSetting')),
        );
    }

    public function getFunctions()
    {
        return array (
            new \Twig_SimpleFunction('congregation_setting', array ($this, 'getCongregationSetting')),
        );
    }

    public function getCongregationSetting($code)
    {
        return $this->congregation->getTypedSetting($code);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'jwkh_extension';
    }
}