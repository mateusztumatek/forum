<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id', 'is_paid', 'price', 'price_sellout', 'image', 'active'];
}
