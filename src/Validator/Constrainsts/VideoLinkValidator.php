<?php

namespace App\Validator\Constrainsts;


use Symfony\Component\String\UnicodeString;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class VideoLinkValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $string = new UnicodeString($value);

        if (!$string->startsWith('https://www.youtube.com')) {
            $this->context->addViolation('L\'url n\'est un lien youtube');
        }
    }
}