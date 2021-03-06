<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //Displaying Auth Page
    public function index()
    {
        if (Session::has('userId')) {
            return redirect('dashboard');
        } else {
            return view('auth/login');
        }
    }

    //Login Authentication
    public function login(Request $request)
    {
        if (Admin::where('email', $request->email)->exists()) {
            $dbUser = Admin::where('email', $request->email)->first();
            if ($dbUser->password == md5($request->password)) {
                Session::put('userId', $dbUser->id);
                Session::put('isAdmin', true);
                return json_encode(['status' => true, 'message' => 'Login Successfull!']);
            } else {
                return json_encode(['status' => false, 'message' => 'Invalid username or password!']);
            }
        } else {
            return json_encode(['status' => false, 'message' => 'Invalid username or password']);
        }
    }

    public function signout(Request $request){
        Session::flush();
        return json_encode(true);
    }
}
