<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

class TravPointAdded implements ShouldBeStored
{
    /** @var string */
    public $accountUuid;

    /** @var int */
    public $amount;

    /** @var string */
    public $origin;

    /** @var string */
    public $note;

    public function __construct(string $accountUuid, int $amount, string $origin, string $note)
    {
        $this->accountUuid = $accountUuid;

        $this->amount = $amount;

        $this->origin = $origin;

        $this->note = $note;
    }
}
