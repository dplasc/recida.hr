<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'code', 'dial_code', 'currency_name', 'currency_symbol', 'currency_code' ];

    public function country_to_city()
    {
        return $this->hasMany(City::class,'country','id');
    }
}
