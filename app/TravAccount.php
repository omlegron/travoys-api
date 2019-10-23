<?php

namespace App;

use Ramsey\Uuid\Uuid;
use App\Events\TravPointAdded;
use App\Events\TravAccountCreated;
use App\Events\TravAccountDeleted;
use App\Events\TravAccountReferred;
use App\Events\TravPointSubtracted;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CouldNotSubtractTravPoint;

class TravAccount extends Model
{
    protected $guarded = [];

    protected $casts = [
        'broke_mail_send' => 'bool',
    ];

    public static function createWithAttributes(array $attributes): TravAccount
    {
        /*
         * Let's generate a uuid.
         */
        $attributes['uuid'] = (string) Uuid::uuid4();

        /*
         * The account will be created inside this event using the generated uuid.
         */
        event(new TravAccountCreated($attributes));

        /*
         * The uuid will be used the retrieve the created account.
         */
        return static::uuid($attributes['uuid']);
    }

    public function setReferral(string $code)
    {
        $referrer = TravAccount::where(['code' => $code])->firstOrFail();

        event(new TravAccountReferred($referrer->uuid, $this->uuid));
        event(new TravPointAdded(
            $referrer->uuid,
            100,
            "Referral from {$this->user->name}",
            "{$this->user->name} ($this->code) has added you as their referrer."
        ));
    }

    public function fillTripPlan()
    {
        $this->addTravPoint(
            100,
            "Travoy",
            "Bonus TravPoint setelah mengisi rencana mudik."
        );
    }

    public function restInTime()
    {
        $this->addTravPoint(
            50,
            "Travoy",
            "Bonus TravPoint setelah visit rest area selama kurang dari 2 jam."
        );
    }

    public function earlyBird()
    {
        $this->addTravPoint(
            500,
            "Travoy",
            "Bonus TravPoint bagi 1.000 pendaftar pertama."
        );
    }

    public function redeem($voucher)
    {
        // TODO: Implement Event Sourcing Aggregate
        if ($this->balance - $voucher->point < 0) {
            throw CouldNotSubtractTravPoint::notEnoughFunds($voucher->point);
        }

        $this->subtractTravPoint(
            $voucher->point,
            "Travoy",
            "Redeem voucher {$voucher->name} ($voucher->redeemable->code)."
        );
    }

    public function addTravPoint(int $amount, string $origin, string $note = "-")
    {
        event(new TravPointAdded($this->uuid, $amount, $origin, $note));
    }

    public function subtractTravPoint(int $amount, string $destination, string $note = "-")
    {
        event(new TravPointSubtracted($this->uuid, $amount, $destination, $note));
    }

    public function remove()
    {
        event(new TravAccountDeleted($this->uuid));
    }

    /*
     * A helper method to quickly retrieve an account by uuid.
     */
    public static function uuid(string $uuid):  ? TravAccount
    {
        return static::where('uuid', $uuid)->first();
    }

    /**
     * Get the user that owns the TravAccount.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
