<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sett extends Model
{
    protected $fillable = ['model', 'foreign_id', 'type', 'value'];
    protected $table = 'my_settings';
}
