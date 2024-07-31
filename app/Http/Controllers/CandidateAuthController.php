<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CandidateActivityLog;
use App\Models\AuditLog;

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

            // Log the login activity
            CandidateActivityLog::create([
                'candidate_id' => Auth::guard('candidate')->id(),
                'activity_type' => 'login'
            ]);

            AuditLog::create([
                // 'user_id' => Auth::guard('candidate')->id(),
                'candidate_id' => Auth::guard('candidate')->id(),
                'activity' => 'Login into system',
                'summary' => serialize('Login into system'),
                'device' => AuditLog::getDeviceDetail(),
            ]);

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
