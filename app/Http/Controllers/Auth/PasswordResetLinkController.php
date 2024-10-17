<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class PasswordResetLinkController extends Controller
{
    /*************************************** Admin *******************************************************/
    /**
     * Display the password reset link request view.
     *
     * @return \Inertia\Response
     */
    public function createAdmin()
    {
        return Inertia::render('Auth/Admin/ForgotPassword', [
            'status' => session('status'),
        ]);
    }


    /*************************************** Parent *******************************************************/
    /**
     * Display the password reset link request view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Parent/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */


    /*************************************** Shared *******************************************************/
    public function store(Request $request)
    {   
        $request->validate([
            'user_email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('user_email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'user_email' => [trans($status)],
        ]);
    }
}
