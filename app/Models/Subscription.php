<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    public function subscription_to_pricing()
    {
        return $this->belongsTo(Pricing::class,'package_id','id');
    }

    public function subscription_to_user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
