<?php

namespace App\Events;

use Spatie\EventProjector\ShouldBeStored;

class TravPointSubtracted implements ShouldBeStored
{
    /** @var string */
    public $accountUuid;

    /** @var int */
    public $amount;

    /** @var string */
    public $destination;

    /** @var string */
    public $note;

    public function __construct(string $accountUuid, int $amount, string $destination, string $note)
    {
        $this->accountUuid = $accountUuid;

        $this->amount = $amount;

        $this->destination = $destination;

        $this->note = $note;
    }
}
