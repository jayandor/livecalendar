<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_category_id',
        'name',
        'description',
        'amount',
        'date',
        'recurring'
    ];

    public $incrementing = false;

    public function calendar()
    {
        return $this->belongsTo('App\UserCalendar', 'user_calendar_id');
    }

    public function category()
    {
        return $this->belongsTo('App\TransactionCategory', 'transaction_category_id');
    }
}
