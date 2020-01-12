<?php

namespace App\Shop;

use Illuminate\Database\Eloquent\Model;

class UserAccesses extends Model
{
    protected $fillable = ['user_id', 'type', 'foreign_key', 'expired_date'];
}
