<?php
namespace App\Shop;

use Illuminate\Database\Eloquent\Model;

class PaymentCategory extends Model{
    protected $fillable = ['price', 'name', 'price_sellout'];
    protected $table = 'shop_categories';
    public function categories(){
        return $this->belongsToMany('App\Category', 'categories_match', 'payment_category_id', 'category_id');
    }
}