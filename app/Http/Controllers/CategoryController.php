<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request){
        if($request->ajax()) return response()->json(Category::where('active', 1)->get());
        return 'fwafaw';
    }
    public function show(Request $request, $slug, $slug_2 = null){
        $category = Category::where('slug', $slug)->where('parent_id', null)->first();
        if(!$category) return redirect(url('/'))->withErrors('Nie ma takiej kategorii');
        if($slug_2){
            $category = Category::where('slug', $slug_2)->where('parent_id', $category->id)->first();
        }
        $category->load('shop_categories');
        $posts = Post::active()->published()->whereHas('categories', function ($q)use($category){
            $q->where('category_id', $category->id);
            if($category->parent_id == null){
                foreach ($category->categories as $sub){
                    $q->orWhere('category_id', $sub->id);
                }
            }
        })->with('rates', 'tags')->paginate(25);
        return view('categories.single', compact('category', 'posts'));
    }
}
