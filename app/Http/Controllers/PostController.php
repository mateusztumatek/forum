<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

class PostController extends Controller
{
    public function create(Request $request){
        return view('posts.edit-add');
    }
    public function edit(Request $request, Post $post){
        if(Auth::id() != $post->user_id) throw new UnauthorizedException();
        return view('posts.edit-add', compact('post'));
    }
    public function show(Request $request, Post $post){
        if(!$post->id) return redirect('/')->withErrors('Nie ma takiego postu');
        $post->load('user');
        return view('posts.single', compact('post'));
    }
    public function store(Request $request){
        $request->request->set('user_id', Auth::id());
        $request->request->set('is_paid', false);
        if($request->attachments){
            $request->request->set('attachments', json_encode(array_values($request->attachments)));
        }
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required',
            'content' => 'required',
        ]);
        $post = Post::create($request->all());
        $this->attachTags($request->tags, $post);
        $this->attachCategories($request->categories, $post);
        return redirect(route('account.index', ['id' => Auth::id()]))->with(['message' => 'Zaktualizowano pomyślnie']);
    }
    public function update(Request $request, Post $post){
        $request->request->set('user_id', Auth::id());
        $request->request->set('is_paid', false);
        if($request->attachments){
            $request->request->set('attachments', json_encode(array_values($request->attachments)));
        }else{
            $request->request->set('attachments', '');
        }
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required',
            'content' => 'required',
        ]);
        $this->attachTags($request->tags, $post);
        $this->attachCategories($request->categories, $post);
        $post->update($request->all());
        return redirect(route('account.index', ['id' => Auth::id()]))->with(['message' => 'Zaktualizowano pomyślnie']);
    }
    public function attachTags($tags, $post){
        $post->tags()->detach();
        if($tags){
            foreach ($tags as $t){
                if(!($tag = Tag::where('tag', $t)->first())){
                    $tag = Tag::create(['tag' => $t]);
                }
                $post->tags()->attach($tag);
            }
        }

    }
    public function attachCategories($categories, $post){
        $post->categories()->detach();
        if($categories){
            foreach ($categories as $t){
                $category = Category::find($t);
                if($category){
                    $post->categories()->attach($category);
                }
            }
        }

    }
}
