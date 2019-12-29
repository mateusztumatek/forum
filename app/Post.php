<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'subtitle', 'content', 'attachments', 'is_paid', 'active', 'published_at'];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
