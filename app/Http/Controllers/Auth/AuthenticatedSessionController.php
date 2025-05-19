<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use MikeMcLin\WpPassword\Facades\WpPassword;

class AuthenticatedSessionController extends Controller
{
    /* Parent */
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Parent/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('user_email', $request->username)->orWhere('user_login', $request->username)->first();

        if ($user) {
            $current_password = $user->user_pass;

            $authorized = false;
            
            if (str_starts_with($current_password, '$wp')) {
                $password_to_verify = base64_encode(hash_hmac('sha384', $request->password, 'wp-sha384', true));
                $authorized = password_verify($password_to_verify, substr($current_password, 3));
            } else {
                $authorized = WpPassword::check($request->password, $current_password);
            }

            // Check the password using the custom algorithm
            if ($authorized) {

                Auth::login($user);

                $request->session()->regenerate();

                return redirect()->intended('home');
            }
        }
 
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function createAdmin()
    {
        return Inertia::render('Auth/Admin/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAdmin(LoginRequest $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('user_email', $request->username)->orWhere('user_login', $request->username)->first();

        if ($user) {
            $current_password = $user->user_pass;

            if (WpPassword::check($request->password, $current_password)) {

                Auth::login($user);

                $request->session()->regenerate();

                return redirect()->intended('/admin/dashboard');
            }
        }
 
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyAdmin(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function impersonate($user_name){
        $user   =   User::where('user_login', $user_name)->first();
        if($user){
            if(Auth::user()->ID == $user->ID && Auth::user()->getImpersonatorID() == '' || Auth::user()->getImpersonatorID() == $user->ID){
                $this->leaveImpersonate();
            }
            else{
                $this->leaveImpersonate();
                Auth::user()->impersonate($user);
            }

            return redirect()->back();

            // $request = Request::capture();
            // if($request->segment(1) == 'admin'){
            //     return Redirect('/admin/dashboard');
            // }
            // return Redirect('/');
        }
        return back()->with(['type'=>'error', 'message'=>'User not found !']);
    }

    public function leaveImpersonate(){
        Auth::user()->leaveImpersonation();
        return back();
    }
}
