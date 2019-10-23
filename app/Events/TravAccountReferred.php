<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

class TravAccountReferred implements ShouldBeStored
{
    /** @var string */
    public $referrerUuid;

    /** @var string */
    public $referredUuid;

    public function __construct(string $referrerUuid, string $referredUuid)
    {
        $this->referrerUuid = $referrerUuid;
        $this->referredUuid = $referredUuid;
    }
}
