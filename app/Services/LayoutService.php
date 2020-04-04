<?php

namespace App\Services;

use App\Attachment;
use App\Post;

class LayoutService{
    public static function getCarousel(){
        if(request()->route()->getName() != 'home') return collect();
        $items = Attachment::where('type', 'main_carousel')->get();
        return $items;
    }
    public static function getSliderPosts(){
        return Post::inRandomOrder()->take(15)->get();
    }
}