<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'file', 'description', 'listing_id', 'listing_type', 'user_id', 'status'
    ];
}
