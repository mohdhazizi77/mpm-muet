<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CandidateActivityLog;
use App\Models\AuditLog;
use App\Models\Candidate;
use App\Models\MuetCalon;
use App\Models\ModCalon;
use Illuminate\Support\Facades\Hash;

class CandidateAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.candidate-login');
    }

    public function login(Request $request)
    {
        //ic remove '-'
        $ic = str_replace('-', '', $request->username);

        $credentials = [
            'identity_card_number' => $request->username, // Assuming 'username' field contains identity card number
            'password' => 12345678
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
        }  else {
            //check from muetCalon or modCalon
            $muetCalon = MuetCalon::where('kp', $ic)->first();
            $modCalon = ModCalon::where('kp', $ic)->first();

            if ($muetCalon || $modCalon) {
                // create candiate record
                $user = Candidate::firstOrCreate(
                    [
                        'identity_card_number' => $ic,
                    ],
                    [
                        'name' => isset($muetCalon->nama) ? $muetCalon->nama : $modCalon->nama,
                        'password'=> Hash::make(12345678),
                    ]
                );

                //asign role
                $user->assignRole('CALON');
            }
        }


        return back()->withInput($request->only('username'))->withErrors(['username' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('candidate')->logout();
        return redirect('/');
    }
}
