<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Client extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = [
        'user_id',
        'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
