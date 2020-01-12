<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

class CommentController extends Controller
{
    public function store(Request $request){
        if(Auth::check()) $request->request->set('user_id', Auth::id());
        $request->validate([
            'email' => 'required|email',
            'comment' => 'required',
            'type' => 'required',
            'foreign_key' => 'required',
            'attachments' => 'array'
        ]);
        if($request->attachments) $request->request->set('attachments', json_encode($request->attachments));
        if(!DB::table($request->type)->where('id', $request->foreign_key)->first()) return response()->json(['errors' => ['Element nie istnieje']], 400);
        $comment = Comment::create($request->all());
        return response()->json($comment);
    }
    public function show(Request $request, $post_id){
        $post = Post::find($post_id);
        if(!$post) return response()->json(['message' => 'Nie znaleziono takiego postu'], 400);
        $comments = Comment::where('type', 'posts')->where('foreign_key', $post->id);
        $comments->orderBy('created_at', 'desc');
        $comments = $comments->with('user', 'rates')->paginate();
        return response()->json($comments);
    }
    public function update(Request $request, $comment_id){
        $comment = Comment::find($comment_id);
        if(!$comment) return response()->json(['Komentarz nie znaleziony'], 400);
        if(!Auth::check() || $comment->user_id != Auth::id()) throw new UnauthorizedException();
        $request->validate([
            'comment' => 'required',
            'attachments' => 'array',
        ]);
        $data = $request->all();
        $data['attachments'] = json_encode($request->attachments);
        $comment->update($data);
        return response()->json($comment);
    }
    public function destroy(Request $request, $id){
        $comment = Comment::find($id);
        if(!$comment) return response()->json(['message' => 'Nie ma takiego komentarza'], 400);
        if(!Auth::check() || Auth::id() != $comment->user_id) throw new UnauthorizedException();
        $comment->delete();
        return response()->json(true);
    }
}
