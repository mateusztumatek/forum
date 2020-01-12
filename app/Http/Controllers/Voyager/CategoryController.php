<?php

namespace App\Http\Controllers\Voyager;

use App\Category;
use App\Shop\PaymentCategory;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController as BaseVoyagerBaseController;

class CategoryController extends BaseVoyagerBaseController
{
    public function getRelationCategories(Request $request){
        if($request->type == 'category_belongstomany_shop_category_relationship'){
            $categories = PaymentCategory::all();
            $categories = $categories->map(function($item){
                return (object) ['id' => $item->id, 'text' => $item->name];
            });
            return response()->json(['results' => $categories, 'pagination' => ['more' => false]]);
        }
        $categories = Category::where('parent_id', null)->where(function ($q)use($request){
            if($request->search){
                $q->where('name', 'LIKE', $request->search.'%');
            }
        })->get();
        $categories = $categories->map(function ($item){
            return (object) ['id' => $item->id, 'text' => $item->name];
        });
        return response()->json(['results' => $categories, 'pagination' => ['more' => false]]);
    }
}
