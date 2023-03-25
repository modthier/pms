<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class UserController extends Controller
{
    

    public function index()
    {
    	$users = User::get();
        // dd($users);
    	return view('admin.users.index',['metaTitle' => 'All Users'])->with('users',$users);
    }


    public function showLoginForm()
    {
        $shifts = Shift::all();
        return view('admin.users.login')->with('shifts',$shifts);
    }


    public function showActivity($id)
    {
        $user = User::findOrFail($id);

        $salesOrders = $user->OrderRequests()->count();
        $purchaseOrders = $user->purchaseOrder()->count();
        $shifts = $user->shifts()->count();
        
        return view('users.activity',['metaTitle' => 'User Activities'])
        ->with([
            'user' => $user , 
            'purchaseOrders' => $purchaseOrders,
            'shifts' => $shifts,
            'salesOrders' => $salesOrders
        ]);
    }


    public function login(Request $request)
    {

        $this->validate($request,[
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
            'shift_id' => 'required'
        ]);

        if ($request->shift_id == 'default') {
            $request->session()->flash('shift','You should choose a Shift');
            return redirect()->route('pms.login');
        }
        
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
            
            $user = Auth::user();
            $user->shifts()->attach($request->shift_id);
            return redirect()->intended('home');
        }else {
            return redirect()->route('pms.login');
        }
    }
   
    public function create()
    {
        $roles = Role::all();
        return view('auth.register')->with('roles',$roles);
    }

    protected function validator(Request $request)
    {
        return Validator::make($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required']
        ]);
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required']
        ]);
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role()->associate($request->role_id);
        $user->save();


        return redirect()->route('register.index');
    }


    public function disableUser($id)
    {
        $user = User::findOrFail($id);


        $status = $user->update([
            'active' => 0
        ]);

        if ($status) {
            return redirect()->route('register.index');
        }
        
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $shifts = Shift::all();



        return view('users.edit')->with(['user' => $user ,'shifts' => $shifts]);
    }


    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'name' => 'required' ,
            'shift_id' => 'required'
        ]);


        $user = User::findOrFail($id);

        $name = $request->name;
        $shift_id = $request->shift_id;

        $data = [
            'name' => $name ,
            'shift_id' => $shift_id
        ];


        if($user->update($data)) {
            return redirect()->route('register.index');
        }
    }


    public function enableUser($id)
    {
        $user = User::findOrFail($id);


        $status = $user->update([
            'active' => 1
        ]);

        if ($status) {
            return redirect()->route('register.index');
        }
        
    }


    public function destroy(Request $request,$id)
    {
        if (Auth::id() == $id) {
            
            return redirect()->route('register.index')->withErrors("You can't delete your own account");
        }

        $user = User::findOrFail($id);
        $user->shifts()->detach();
        
        User::destroy($id);
        $request->session()->flash('success',"User Deleted Successfully");
        return redirect()->route('register.index');
    }


    public function resetPasswordForm($id)
    {
        $user = User::findOrFail($id);
        return view('users.resetPassword',['metaTitle' => 'Reset Password'])->with('user',$user);
    }

    public function resetPassword(Request $request,$id)
    {

        $this->validate($request,[
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required','string', 'min:8']
        ]);

        $user = User::findOrFail($id);
        
       
        if ($request->password === $request->confirm_password) {

        $hashed_password = Hash::make($request->password);

        $user->update([
            'password' => $hashed_password
        ]);

        if (Auth::id() == $id) {
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

             Auth::guard()->logout();

             $request->session()->invalidate();

             $request->session()->regenerateToken();

             return  redirect()->route('login');
        }else {
            $request->session()->flash('success','New password is updated');
            return redirect()->route('register.index');
        }
        


        }else {
            $request->session()->flash('error','New password and confirm password does not match');
            return  redirect()->route('user.resetPasswordForm',$user->id);
        }
       
    }

   
  
    

   
}
