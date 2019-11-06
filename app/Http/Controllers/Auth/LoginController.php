<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use App\UserLoginLogs;
use Auth;
use App\Clients;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	protected function credentials(\Illuminate\Http\Request $request)
    {
        //return $request->only($this->username(), 'password');
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'approved_status' => '1'];
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    function authenticated(\Illuminate\Http\Request $request, $user)
    {
        $data=new UserLoginLogs;
        $data->user_id=$user->id;
        $data->last_login_at=Carbon::now()->toDateTimeString();
        $data->last_login_ip=$request->ip();
        $data->system="Accounting";
        
        $data->save();
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->ip()
        ]);
        
    }
}
