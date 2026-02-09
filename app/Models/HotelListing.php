<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelListing extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function cityToCity()
    {
        return $this->belongsTo(City::class,'city','id');
    }

    public function countryToCountry()
    {
        return $this->belongsTo(Country::class,'country','id');
    }
}
