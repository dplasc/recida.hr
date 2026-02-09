<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Type\VoidType;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payment_geteways';

    public static function success_url($identifier){
        echo $identifier;
        die;
    }
}
