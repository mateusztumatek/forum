<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    public function showLoginForm()
    {
        return view('home')->with(['login' => 'true']);
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            return response()->json(['redirect_link' => url('/'), 'user' => $this->guard()->user()]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    public function username()
    {
        $login = request()->input('email');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
        request()->merge([$field => $login]);

        return $field;
    }
    public function redirectSocial(Request $request, $type){
        return Socialite::driver($type)->redirect();
    }
    public function callback(Request $request, $type){
        $user = Socialite::driver($type)->stateless()->user();
        try{
            if($existed = User::where('email', $user->getEmail())->where('is_'.$type, 1)->first()){
                $new_user = $existed;
            }else{
                $new_user = User::create([
                    'login' => $user->getEmail(),
                    'email' => $user->getEmail(),
                    'name' => $user->getName(),
                    'is_facebook' => ($type == 'facebook')? true : false,
                    'is_google' => ($type == 'google')? true : false,
                    'password' => Hash::make('password'),
                    'avatar' => $user->getAvatar(),
                    'email_verified_at' => Carbon::now()->subHour()
                ]);
            }

        }catch(\Exception $e){
            return redirect()->to('/login')->withErrors('Błąd podczas tworzenia użytkownika');
        }
        Auth::login($new_user);
        return redirect()->to('/');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
