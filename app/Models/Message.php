<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    public $fillable = [ 
        'user_id',
        'message',
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
