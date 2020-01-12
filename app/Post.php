<?php

namespace App;

use App\Shop\PaymentCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'subtitle', 'content', 'attachments', 'is_paid', 'active', 'published_at'];
    protected $appends = ['url', 'payment_categories'];
    protected $dates = ['published_at'];
    public function getUrlAttribute(){
        return route('posts.show', ['id' => $this->id]);
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function getPaymentCategoriesAttribute(){
        if(!$this->is_paid) return [];
        $categories = $this->categories;
        return PaymentCategory::whereHas('categories', function($q)use($categories){
            foreach ($categories as $c){
                $q->orWhere('category_id', $c->id);
            }

        })->get();
    }
    public function scopeActive($q){
        $q->where('active', 1);
        return $q;
    }
    public function scopePublished($q){
        $q->where('published_at', '<=', Carbon::today());
        return $q;
    }
    public function scopeFilter($q){
        if(request('term')){
            $q->where('title', 'LIKE', '%'.request('term').'%');
            $q->orWhere('content', 'LIKE', '%'.request('term').'%');
            return $q;
        }
    }
    public function tags(){
        return $this->belongsToMany('App\Tag', 'posts_tags');
    }
    public function categories(){
        return $this->belongsToMany('App\Category', 'post_categories');
    }
    public function rates(){
        return $this->hasMany('App\Rate', 'foreign_key')->where('table', 'posts');
    }
    public function hasAccess($user){
        if(!$this->is_paid) return true;
        $payment_categories = $this->payment_categories;
        if(count($payment_categories) > 0){
            $accesses = $user->accesses()->where('type', 'category')->get();
            foreach ($payment_categories as $payment_category){
                $temp = $accesses->where('foreign_key', $payment_category->id)->first();
                if($temp && $temp->id) return true;
            }
            return false;
        }else{
            return true;
        }
    }
}
