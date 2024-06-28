<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        $user = User::where('email', $request->email)->first();

        if($user){
            if($user->is_deleted == 1){
                // return response('Your Account in Inactive, Please contact system admin', 422);
                return redirect()->back()->with('fail', 'Your Account is Inactive, Please contact system admin');
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect(route('admin.index'));
            }
        }


        return back()->withInput($request->only('email'))->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard()->logout();
        return redirect('/admin/login');
    }
}
