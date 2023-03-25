<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Shift;
use DB;
use Carbon\Carbon;
use Artisan;
use Auth;
use Log;
use Session;
use Illuminate\Support\Facades\Storage;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $shifts = Shift::all();
        return view('auth.login')->with('shifts',$shifts);
    }


    protected function authenticated(Request $request, $user)
    {
        $user->shifts()->attach($request->shift_id);
    }


    public function logout(Request $request)
    {
        $today = date('Y-m-d');
        $current_date_time = Carbon::now()->toDateTimeString();

       $result =  DB::table('shift_user')
            ->select(['id'])
            ->where('user_id',Auth::id())
            ->whereDate('created_at',$today)
            ->latest('created_at')->first();
            
         if (!empty($result)) {
             DB::table('shift_user')
            ->where('id',$result->id)
            ->update(['loggedout_at' => $current_date_time]);
         }
         
        Artisan::call('backup:run --only-db');
       
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/');
    }
}
