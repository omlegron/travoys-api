<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use App\Notifications\VerifyEmailQueued;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'name', 'email', 'password', 'phone', 'device_id', 'fcm_device_token',
        'saldo',
        'golongan',
        'rf_idkey',
        'golongan_kendaraan',
        'plat_no_kendaraan',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailQueued);
    }

    /**
     * Get the user's email verification status.
     *
     * @return bool
     */
    public function getIsVerifiedAttribute()
    {
        return $this->hasVerifiedEmail();
    }

    /**
     * Get the user's satgas role status.
     *
     * @return bool
     */
    public function getIsSatgasAttribute()
    {
        return $this->satgasAt()->exists();
    }

    /**
     * Route notifications for the FCM channel.
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->fcm_device_token;
    }

    /**
     * Get feedback written by user.
     */
    public function feedback()
    {
        return $this->hasMany('App\Feedback');
    }

    /**
     * The rest area that the user assigned at.
     */
    public function satgasAt()
    {
        return $this->belongsToMany('App\RestArea', 'rest_area_user', 'user_id', 'rest_area_id');
    }

    /**
     * Get the travAccount record associated with the user.
     */
    public function travAccount()
    {
        return $this->hasOne('App\TravAccount');
    }

    /**
     * Get the voucher codes redeemed by the user.
     */
    public function voucherCodes()
    {
        return $this->hasMany('App\VoucherCode', 'redeemer_id');
    }

    /**
     * The vouchers that redeemed by the user.
     */
    public function vouchers()
    {
        return $this->belongsToMany('App\Voucher', 'voucher_codes', 'redeemer_id');
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function checkIn()
    {
        return $this->hasMany(CheckIn::class);
    }
}
