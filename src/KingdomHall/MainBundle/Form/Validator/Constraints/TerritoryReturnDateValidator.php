<?php
/**
 * Created by PhpStorm.
 * User: gpetit
 * Date: 7/14/15
 * Time: 4:46 PM
 */

namespace KingdomHall\MainBundle\Form\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TerritoryReturnDateValidator extends ConstraintValidator {

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value->getReturnDate() && $value->getReturnDate() < $value->getBorrowDate()) {
            $this->context->addViolationAt('returnDate', $constraint->message);
        }
    }
}