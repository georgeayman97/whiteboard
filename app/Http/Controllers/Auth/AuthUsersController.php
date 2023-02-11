<?php

namespace App\Http\Controllers\Auth;

use Rules\Password;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class AuthUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        if(auth()->user()->role == 'doctor'){
            $users = User::where('role','!=','admin')->where('role','!=','doctor')->orderBy('created_at','desc')->with('faculty')->whereHas('faculty', function ($query) {
                return $query->where('id', '=', auth()->user()->faculty_id);
            })->paginate(20);
        }else{
            $users = User::where('role','!=','admin')->where('role','!=','doctor')->orderBy('created_at','desc')->with('faculty')->paginate(20);
        }
        $success = session()->get('success');
        return view('admin.accounts.index',[
            'users' => $users,
            'success' => $success,
        ]);
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        
        if($user) {
            $user->status = User::STATUS_ACTIVE;
            $user->save();
        }
        return back()->with('success',"$user->name Activated Successfully");
    }
    

    public function ban($id)
    {
        $user = User::findOrFail($id);
        
        if($user) {
            $user->status = User::STATUS_DISABLED;
            $user->save();
        }
        return back()->with('success',"$user->name Banned Successfully");
    }

    public function resetDevice($id)
    {
        $user = User::findOrFail($id);
        
        if($user) {
            $user->device_name = 'Admin_registeration';
            $user->save();
        }
        return back()->with('success',"$user->name Activated Successfully");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('auth.edit-user',[
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
            'password' => ['confirmed'],
        ]);
        $user = User::findOrFail($id);
        if($request->password == null){
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'year' => $request->year,
                'forget_password' => 0,
            ]);
        }else{
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'year' => $request->year,
                'password' => Hash::make($request->password),
                'forget_password' => 0,
            ]);
        }
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        
        return back()->with('success',"$user->name Deleted Successfully");
    }
}
