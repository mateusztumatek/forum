<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id', 'image', 'active', 'slug'];
    public $appends = ['url'];

    public function getUrlAttribute(){
        if($this->parent_id){
            return route('categories.show', ['slug' => $this->parent->slug, 'slug_2' => $this->slug]);
        }
        return route('categories.show', ['id' => $this->slug]);
    }
    public function parent(){
        return $this->belongsTo('App\Category', 'parent_id');
    }
    public function categories(){
        return $this->hasMany('App\Category', 'parent_id');
    }
    public function shop_categories(){
        return $this->belongsToMany('App\Shop\PaymentCategory', 'categories_match', 'category_id', 'payment_category_id');
    }
}
