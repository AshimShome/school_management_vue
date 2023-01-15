<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the response for a successful password reset.
     */
    protected function sendResetResponse(Request $request, string $response)
    {
        return ['status' => trans($response)];
    }

    /**
     * Get the response for a failed password reset.
     */
    protected function sendResetFailedResponse(Request $request, string $response)
    {
        return response()->json(['email' => trans($response)], 400);
    }

    public function resetPassword(Request $request)
    {
        $input = $request->only('email', 'token', 'password', 'password_confirmation');
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $response = Password::reset($input, function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();
            //$user->setRememberToken(Str::random(60));
            event(new PasswordReset($user));
        });

        if ($response) {
            return response()->json([
                'message' => 'Password reset successfully',
                'success' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'Password reset failed',
                'success' => false
            ], 400);
        }
    }
}
