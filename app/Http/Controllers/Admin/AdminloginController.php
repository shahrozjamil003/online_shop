<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminloginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function authenticate(Request $request){
        $request->validate([
            'email' => 'required | email',
            'password' => 'required',
        ]);

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))){

            $admin = Auth::guard('admin')->user();
            if($admin->role == 2){
                return redirect()->route('admin.dashboard');
            }else{
                Auth::guard('admin')->logout();
                return redirect()->route('admin.login')
            ->with('error', 'Your are not authorise to access Admin Panel');
            }

            
        }else{
            return redirect()->route('admin.login')
            ->with('error', 'The provided credentials are incorrect.');

        }
    }
}
