<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 12.10.15
 * Time: 14:41
 */

namespace Acme\Bundle\EventManagerBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsAppropriateWordsAmountValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $wordsAmount = $this->countWords($value);

        if ($wordsAmount < $constraint->minimalWordsAmount) {
            $this->context->addViolation($constraint->notEnoughWordsMessage,
                array('%wordsAmount%' => $wordsAmount));
        }
        if ($constraint->maximalWordsAmount < $wordsAmount) {
            $this->context->addViolation($constraint->tooManyWordsMessage,
                array('%wordsAmount%' => $wordsAmount));
        }
    }

    private function countWords($value)
    {
        return str_word_count($value);
    }
}