<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Str;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, $id, $tab = null)
    {
        $user = User::find($id);
        if(!$user->id){
            return redirect(url('/'))->withErrors([trans('my.Nie ma takiego użytkownika')]);
        }
        if($tab != 'comments' || $tab != ''){
            if(Auth::id() != $user->id) throw new UnauthorizedException();
        }
        $data = [];
        if(!$tab || $tab == ''){
            $posts = Post::where('user_id', $user->id)->with('user')->paginate(10);
            $data['posts'] = $posts;
        }
        if($tab == 'account'){
            $user->first_login = false;
            $user->update();
        }

        return view('auth.show')->with(array_merge(['user' => $user, 'tab' => $tab], $data));
    }
    public function update(Request $request, $id){
        $user = User::find($id);
        if(!$user || Auth::id() != $user->id) throw new UnauthorizedException();
        if(!$request->tab || $request->tab == ''){
            $request->validate([
                'login' => ['required', function($field, $data, $fail)use($user){
                    $find = User::where('login', $data)->first();
                    if($find && $find->id != $user->id) $fail('Ten login jest już zajęty');
                }],
                'name' => 'required|min:4',
            ]);
            $user->update($request->all());
        }
        if($request->tab == 'privacy'){
            $request->validate([
                'new_email' => 'required|email',
            ]);
            if($request->new_password){
                $request->validate([
                    'new_password' => 'min:4|confirmed'
                ]);
            }
            $user->update_code = \Illuminate\Support\Str::random(5);
            $user->update();
            $user->update($request->all());
        }
        return back()->with(['messae' => 'Zaktualizowano pomyślnie']);
    }
}
