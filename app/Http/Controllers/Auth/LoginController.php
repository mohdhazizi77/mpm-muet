<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //    use AuthenticatesUsers;

    public function showLoginForm()
    {
        // dd(Auth::User());
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.admin-login');
    }

    protected function redirectBasedOnRole()
    {
        $user = Auth::user();
        // $user->hasRole('PENTADBIR')

        if (in_array($user->roles->pluck('name')->toArray()[0], array('PENTADBIR','BPCOM','PSM','FINANCE')) ) {
            return redirect()->route('admin.index');
        } elseif ($user->hasRole('CALON')) {
            return redirect()->route('candidate.index');
        }

        // You can add more role checks here if needed.
    }

    public function showAdminLoginForm()
    {
        return view('auth.admin-login', ['url' => 'admin/login']);
    }

    public function showCandidateLoginForm()
    {
        return view('auth.candidate-login', ['url' => 'candidate/login']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/admin');
        }

        return back()->withInput($request->only('username'))->withErrors(['username' => '  123']);
    }

    public function candidateLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return $this->redirectBasedOnRole();
        }
        // if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        //     return redirect()->intended('/candidate');
        // }

        return back()->withInput($request->only('username'))->withErrors(['username' => 'Invalid credentials']);
    }

    public function candidateLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

//    protected $redirectTo = RouteServiceProvider::HOME;

//    protected function authenticated(Request $request, $user)
//    {
//        if (Auth::User()->HasRole('CALON')) {
//            return redirect(route('candidates.index'));
//        } else {
//            return route('/');
//        }
//    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest')->except('logout');
//    }
}
