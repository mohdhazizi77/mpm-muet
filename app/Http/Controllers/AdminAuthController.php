<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect(route('admin.index'));
        }

        return back()->withInput($request->only('email'))->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard()->logout();
        return redirect('/admin/login');
    }
}
