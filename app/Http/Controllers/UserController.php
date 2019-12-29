<?php

namespace App\Http\Controllers;

use App\Mail\UpdateCodeMail;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Mail;
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
            if($request->new_email){
                $request->validate([
                    'new_email' => ['required', 'email', function($field, $data, $fail)use($user){
                        if($data == $user->email) $fail('Nowy adres email musi się różnić od poprzedniego');
                        if($us = User::where('email', $data)->first()){
                            $fail('Ten email jest już zajęty');
                        }
                    }],
                ]);
            }
            if($request->new_password){
                $request->validate([
                    'new_password' => 'min:4|confirmed'
                ]);
            }
            if($request->code){
                $request->validate([
                    'code' => [function($field, $data, $fail)use($user){
                        if($user->update_code == null) $fail('Brak kodu');
                        if($user->update_code != $data) $fail('Błędny kod');
                    }]
                ]);
                $validated = true;
            }
            $data = array();
            ($request->new_email)? $data['email'] = $request->new_email : null;
            ($request->new_password)? $data['password'] = $request->new_password : null;
            $user->update_code = \Illuminate\Support\Str::random(5);
            Mail::to((array_key_exists('email', $data)? $data['email'] : $user->email))->send(new UpdateCodeMail($user));
            $user->update();
            if(isset($validated) && $validated){
                $data['update_code'] = null;
                $user->update($data);
            }
        }
        if($request->hasHeader('is_ajax')) return response()->json($user);
        return back()->with(['messae' => 'Zaktualizowano pomyślnie']);
    }
}
