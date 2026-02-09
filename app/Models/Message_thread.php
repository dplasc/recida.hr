<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message_thread extends Model
{
    use HasFactory;
    protected $table = 'message_thread';
    protected $fillable = [
        'message_thread_id',
        'message_thread_code',
        'sender',
        'receiver',
        'created_at',
        'updated_at',
    ];

    public function message_to_sender()
    {
        return $this->belongsTo(User::class,'sender','id');
    }

    public function message_to_receiver()
    {
        return $this->belongsTo(User::class,'receiver','id');
    }
}
