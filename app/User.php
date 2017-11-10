<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function isSameAs(User $user) {
        return $this->getKey() == $user->getKey();
    }

    public function calendars() {
        return $this->hasMany('App\UserCalendar');
    }

    // Get calendar by user-specific ID. Each user has their own ID's for their
    // own calendars, so user A's calendar 1 will be different that user B's
    // calendar 1. (Note that this ID is different than the canonical calendar
    // ID)
    public function user_calendar($user_calendar_id) {
        return $this->calendars()
            ->where('user_calendar_id', $this->id);
    }

    public function transaction_categories() {
        return $this->hasMany('App\TransactionCategory');
    }

    public function transactions() {
        return $this->hasManyThrough(
            'App\Transaction',
            'App\UserCalendar'
        );
    }

}
