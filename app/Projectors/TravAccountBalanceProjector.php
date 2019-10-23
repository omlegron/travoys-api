<?php

namespace App\Projectors;

use App\TravAccount;
use App\Events\TravPointAdded;
use App\Events\TravAccountCreated;
use App\Events\TravAccountDeleted;
use App\Events\TravPointSubtracted;
use Spatie\EventProjector\Projectors\Projector;
use Spatie\EventProjector\Projectors\ProjectsEvents;

class TravAccountBalanceProjector implements Projector
{
    use ProjectsEvents;

    public function onTravAccountCreated(TravAccountCreated $event)
    {
        TravAccount::create($event->accountAttributes);
    }

    public function onTravPointAdded(TravPointAdded $event)
    {
        $account = TravAccount::uuid($event->accountUuid);

        $account->balance += $event->amount;

        $account->save();
    }

    public function onTravPointSubtracted(TravPointSubtracted $event)
    {
        $account = TravAccount::uuid($event->accountUuid);

        $account->balance -= $event->amount;

        $account->save();
    }

    public function onTravAccountDeleted(TravAccountDeleted $event)
    {
        TravAccount::uuid($event->accountUuid)->delete();
    }
}
