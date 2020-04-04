<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['url', 'page_title', 'page_description', 'data', 'html', 'css'];
}
