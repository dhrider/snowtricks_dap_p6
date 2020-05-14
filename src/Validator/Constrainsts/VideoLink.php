<?php

namespace App\Validator\Constrainsts;

use Symfony\Component\Validator\Constraint;

class VideoLink extends Constraint
{
    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}
