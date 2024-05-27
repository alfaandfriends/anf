<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Corcel\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // if(auth()->user()->is_admin){
        return redirect('/home');
        // return redirect()->intended(RouteServiceProvider::HOME);
        // }
        // else{
        //     return redirect('diagnostic_test');
        // }
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
        $request->authenticate();

        $request->session()->regenerate();

        // if(auth()->user()->is_admin){
        return redirect('/admin/dashboard');
        // return redirect()->intended(RouteServiceProvider::HOME);
        // }
        // else{
        //     return redirect('diagnostic_test');
        // }
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
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function createCRM()
    {
        return Inertia::render('Auth/CRM/Login', [
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
    public function storeCRM(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // if(auth()->user()->is_admin){
        return redirect('/crm/dashboard');
        // return redirect()->intended(RouteServiceProvider::HOME);
        // }
        // else{
        //     return redirect('diagnostic_test');
        // }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyCRM(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/crm/login');
    }

    public function impersonate($user_name){
        $user   =   User::where('user_login', $user_name)->first();
        if($user){
            if(auth()->user()->ID == $user->ID && auth()->user()->getImpersonatorID() == '' || auth()->user()->getImpersonatorID() == $user->ID){
                $this->leaveImpersonate();
            }
            else{
                $this->leaveImpersonate();
                auth()->user()->impersonate($user);
            }

            $request = Request::capture();
            if($request->segment(1) == 'admin'){
                return Redirect('/admin/dashboard');
            }
            return Redirect('/');
        }
        return back()->with(['type'=>'error', 'message'=>'User not found !']);
    }

    public function leaveImpersonate(){
        auth()->user()->leaveImpersonation();
        return back();
    }
}
