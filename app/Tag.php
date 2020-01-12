<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag', 'count'];
    protected $appends = ['url'];
    public function getUrlAttribute(){
        return url('/tags/'.$this->id.'/'.$this->tag);
    }
}
