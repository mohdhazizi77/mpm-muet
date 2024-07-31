<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;


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

                AuditLog::create([
                    'user_id' => Auth::User()->id,
                    // 'candidate_id' => Auth::guard('candidate')->id(),
                    'activity' => 'Login into system',
                    'summary' => serialize('Login into system'),
                    'device' => AuditLog::getDeviceDetail(),
                ]);

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
