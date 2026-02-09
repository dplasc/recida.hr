<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimedListing extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_name', 'user_phone', 'additional_info', 'listing_id', 'listing_type', 'user_id', 'status'
    ];
}
