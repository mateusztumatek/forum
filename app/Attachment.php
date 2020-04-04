<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['name', 'type', 'content', 'links', 'images', 'data'];
    protected $appends = ['alignment'];
    public function getDataAttribute($data){
        if(!$data) return null;
        if(request()->route()->getPrefix() == '/admin') return $data;
        return json_decode($data);
    }
    public function getAlignmentAttribute(){
        if($this->data && property_exists($this->data, 'alignment')){
            return $this->data->alignment;
        }
        return null;
    }
}
