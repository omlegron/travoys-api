<?php

namespace App\Exceptions;

use Exception;

class CouldNotSubtractTravPoint extends Exception
{
    public static function notEnoughFunds(int $amount): self
    {
        return new static("Could not subtract {$amount} point because you can not go below 0.");
    }
}
