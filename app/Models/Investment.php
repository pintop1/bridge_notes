<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
	    return $this->belongsTo(User::class);
    }
      public function plan()
    {
	    return $this->belongsTo(Plan::class);
    }

    public function payouts()
    {
	    return $this->hasMany(Payout::class);
    }
}
