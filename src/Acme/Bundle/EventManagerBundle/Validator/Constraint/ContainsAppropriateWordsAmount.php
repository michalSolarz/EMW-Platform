<?php
/**
 * Created by PhpStorm.
 * User: bezimienny
 * Date: 12.10.15
 * Time: 15:17
 */

namespace Acme\Bundle\EventManagerBundle\Validator\Constraint;


use Symfony\Component\Validator\Constraint;

/**
 * Class ContainsAppropriateWordsAmount
 * @package Acme\Bundle\EventManagerBundle\Validator\Constraint
 * @Annotation
 */
class ContainsAppropriateWordsAmount extends Constraint
{
    public $minimalWordsAmount = 50;
    public $maximalWordsAmount = 500;
    public $notEnoughWordsMessage = 'The text contains not enough words. Minimal words amount: 50 and You have written: %wordsAmount%.';
    public $tooManyWordsMessage = 'The text contains too many words. Maximal words amount: 500 and You have written: %wordsAmount%.';

}