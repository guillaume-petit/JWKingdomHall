<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 6/22/15
 * Time: 2:06 PM
 */

namespace KingdomHall\ServiceBundle\Listener;


use KingdomHall\ServiceBundle\Service\CongregationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CongregationConverter
 *
 * Converts the congregation code in the url parameters in Congregation entity
 *
 * @package KingdomHall\MainBundle\Listener
 */
class CongregationConverter implements ParamConverterInterface {

    /** @var CongregationService $congregationService */
    protected $congregationService;

    /**
     * Constructor
     *
     * @param CongregationService $congregationService
     */
    public function __construct(CongregationService $congregationService)
    {
        $this->congregationService = $congregationService;
    }

    /**
     * Applies the conversion
     *
     * @param Request        $request       the request
     * @param ParamConverter $configuration the configuration
     *
     * @return bool
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $congregationCode = strtolower($request->attributes->get('congregationCode'));


        if ($congregationCode) {
            $congregation = $this->congregationService->findByCode($congregationCode);

            if ($congregation) {
                $request->attributes->set($configuration->getName(), $congregation);
            } else {
                throw new NotFoundHttpException('Unknown congregation code: ' . $congregationCode);
            }
        }

    }

    /**
     * @param ParamConverter $configuration the configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        return ($configuration->getClass() === 'KingdomHall\DataBundle\Entity\Congregation');
    }
}