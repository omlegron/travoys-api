<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

class TravAccountCreated implements ShouldBeStored
{
    /** @var array */
    public $accountAttributes;

    public function __construct(array $accountAttributes)
    {
        $this->accountAttributes = $accountAttributes;
    }
}
