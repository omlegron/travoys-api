<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\RedirectsUsers;

class VerificationController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = 'https://travoy.id/verification/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('verify');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!$user) {
            return response()->json([
                'errors' => [
                    'status' => '404',
                    'title' => 'Not Verifying',
                    'detail' => 'User doesn\'t exist.',
                ],
            ], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'errors' => [
                    'status' => '422',
                    'title' => 'Not Verifying',
                    'detail' => 'User has verified this email address.',
                ],
            ], 400);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            if (User::whereNotNull('email_verified_at')->count() <= 1000) {
                $user->travAccount->earlyBird();
            }
        }

        return redirect($this->redirectPath())->with('verified', true);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'errors' => [
                    'status' => '422',
                    'title' => 'Not Resending Email',
                    'detail' => 'User has verified this email address.',
                ],
            ], 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'data' => [
                'type' => 'email-verification-resend',
                'attributes' => [
                    'message' => 'Verification email sent.',
                ],
            ],
        ]);
    }

    /**
     * Check if email address is verified
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        if (!$request->user()->hasVerifiedEmail()) {
            return response()->json([
                'data' => [
                    'type' => 'email-verification-check',
                    'attributes' => [
                        'verified' => false,
                        'message' => 'Email not verified.',
                    ],
                ],
            ]);
        }

        return response()->json([
            'data' => [
                'type' => 'email-verification-check',
                'attributes' => [
                    'verified' => true,
                    'message' => 'Email has been verified.',
                ],
            ],
        ]);
    }
}
