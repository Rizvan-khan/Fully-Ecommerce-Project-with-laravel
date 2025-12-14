<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class User_detail extends Model
{
   protected $fillable = [
        'user_id',
        'address',
        'district',
        'state',
        'country',
        'pin_code',
        'shipping_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
