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

        $credentials = [
            'identity_card_number' => $request->username, // Assuming 'username' field contains identity card number
            'password' => $request->username
        ];

        if (Auth::guard('candidate')->attempt($credentials)) {
            // Authentication successful
            return redirect()->route('candidate.index');
        }

        return back()->withInput($request->only('username'))->withErrors(['username' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('candidate')->logout();
        return redirect('/');
    }
}
