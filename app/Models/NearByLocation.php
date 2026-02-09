<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NearbyLocation extends Model
{
    use HasFactory;

    protected $table = 'nearby_location';

    protected $fillable = [ 'id','type', 'name','nearby_id','latitude','longitude','listing_id','listing_type','created_at','updated_at' ];

    public function nearby_to_listing()
    {
        return $this->belongsTo(RealEstateListing::class,'listing_id','id');
    }
}
