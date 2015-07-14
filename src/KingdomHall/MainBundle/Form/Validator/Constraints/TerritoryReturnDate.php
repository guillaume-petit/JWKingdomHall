<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/14/15
 * Time: 4:44 PM
 */

namespace KingdomHall\MainBundle\Form\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class TerritoryReturnDate
 * @package KingdomHall\MainBundle\Form\Validator\Constraints
 *
 * @Annotation
 */
class TerritoryReturnDate extends Constraint {

    public $message = 'jwkh.territories.return.error.return_date';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}