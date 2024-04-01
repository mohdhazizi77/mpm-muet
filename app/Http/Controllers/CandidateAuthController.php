<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.candidate-login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect(route('candidates.index'));
        }

        return back()->withInput($request->only('username'))->withErrors(['username' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard()->logout();
        return redirect('/candidate/login');
    }
}
