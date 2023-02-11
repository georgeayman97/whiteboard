<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function index()
    {
        $doctors = User::where('role','doctor')->get()->load('teaches');
        return view('admin.accounts.doctors',['doctors'=>$doctors]);
    }
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if(auth()->user()->role == 'doctor'){
            $faculties = Faculty::where('id',auth()->user()->faculty_id)->get();
        }else{
            $faculties = Faculty::all();
        }
        return view('auth.register',['faculties'=>$faculties]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'year' => ['required', 'string', 'max:255'],
            'faculty_id'=> ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // dd(User::where('mobile', $request->mobile));
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'year' => $request->year,
            'faculty_id'=>$request->faculty_id,
            'status' => User::STATUS_REQUEST,
            'device_name' => 'Admin_registeration',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function createDoctor()
    {
        $faculties = Faculty::all();
        return view('auth.register-doctor',['faculties'=>$faculties]);
    }
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeDoctor(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'year' => ['required', 'string', 'max:255'],
            'faculty_id'=> ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // dd(User::where('mobile', $request->mobile));
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'year' => $request->year,
            'role' => "doctor",
            'faculty_id'=>$request->faculty_id,
            'status' => User::STATUS_ACTIVE,
            'device_name' => 'Admin_registeration',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    public function createAdmin()
    {
        return view('auth.register-admin');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'faculty_id'=>1,
            'year' => '1',
            'faculty_id'=>1,
            'role' => "admin",
            'status' => "active",
            'device_name' => 'Admin_registeration',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);
    }
    
    public function showForgetPass()
    {
        if(auth()->user()->role == 'doctor'){
            $users = User::where('faculty_id',auth()->user()->faculty_id)->where('forget_password',1)->paginate(20);
        }else{
            $users = User::where('forget_password',1)->paginate(20);
        }
        $success = session()->get('success');
        return view('admin.accounts.forgetPass',[
            'users' => $users,
            'success' => $success,
        ]);
    }
}
