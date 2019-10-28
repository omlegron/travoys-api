<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Carbon\Carbon;
use App\TravAccount;
use Illuminate\Http\Request;
use Swift_TransportException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Propaganistas\LaravelPhone\PhoneNumber;
use App\Http\Resources\User as UserResource;

use App\Http\Mail\TestMail;
use Mail;

class RegisterController extends Controller
{
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        try {
            event(new Registered($user = $this->create($request->all())));
             // Mail::to($request->email)->send(new TestMail($this,'','',''));
        } catch (Swift_TransportException $e) {
            if (isset($user)) {
                $user->delete();
            }

            return response()->json([
                'errors' => [
                    'status' => '500',
                    'title' => 'Internal Server Error',
                    'detail' => 'Invalid mail server configuration.',
                ],
            ], 500);
        } catch (Exception $e) {
            if (isset($user)) {
                $user->delete();
            }

            return response()->json([
                'errors' => [
                    'status' => '500',
                    'title' => 'Unknown Error',
                    'detail' => $e->getMessage(),
                ],
            ], 500);
        }

        $token = $this->generateToken($user);
        $user['auth'] = [
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $token->token->expires_at
            )->toDateTimeString(),
        ];

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['phone'] = PhoneNumber::make($data['phone'], 'ID')->formatE164();

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'phone:ID,mobile', 'max:255'],
            'device_id' => ['required', 'string', 'max:255', 'unique:users'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => PhoneNumber::make($data['phone'], 'ID')->formatE164(),
            'device_id' => $data['device_id'],
            'fcm_device_token' => $data['fcm_device_token'],
        ]);

        try {
            TravAccount::createWithAttributes([
                'user_id' => $user->id,
                'code' => $this->randomCode(),
            ]);
        } catch (Exception $e) {
            $user->delete();

            throw $e;
        }

        return $user;
    }

    /**
     * Generate random code for travAccount
     *
     * @param  array  $data
     * @return \App\User
     */
    public function randomCode()
    {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $max = strlen($characters) - 1;
        $code = "";

        for ($i = 0; $i < 7; $i++) {
            $code .= $characters[mt_rand(0, $max)];
        }

        $validator = Validator::make(['code' => $code], [
            'code' => 'unique:trav_accounts,code',
        ]);

        if ($validator->fails()) {
            return $this->randomCode();
        }

        return $code;
    }

    /**
     * Generate token for authenticated user.
     *
     * @param User $user
     * @return mixed
     */
    protected function generateToken(User $user)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return $tokenResult;
    }
}
