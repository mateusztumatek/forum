<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['model', 'foreign_id', 'type', 'value'];
    protected $table = 'my_settings';
}
