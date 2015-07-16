<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/7/15
 * Time: 2:47 PM
 */

namespace KingdomHall\MainBundle\Twig;


use KingdomHall\DataBundle\Entity\Congregation;
use Symfony\Component\HttpFoundation\RequestStack;

class JWKHExtension extends \Twig_Extension
{

    /** @var  Congregation */
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
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
        return $this->request->get('congregation')->getTypedSetting($code);
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