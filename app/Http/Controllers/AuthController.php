<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        $fixedEmail = 'demo123@gmail.com';

        // Retrieve the user with the fixed email
        $user = User::where('email', $fixedEmail)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication successful
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Login Success');
        }

        // Authentication failed
        return back()->with('error', 'Invalid email or password');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
