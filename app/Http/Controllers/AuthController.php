<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

use App\Mail\PasswordResetEmail;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'fullname' => 'required|string',
            'password' => 'required',
        ]);

        try {

            $user = new User;
            $user->fullname = $request->input('fullname');
            $user->birthday = $request->input('birthday');
            $user->country = $request->input('country');
            $user->document_number = $request->input('document_number');
            $user->document_type = $request->input('document_type');
            $user->gender = $request->input('gender');
            $user->phone = $request->input('phone');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed! ' . $e], 409);
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Create a reset code for the email.
     *
     * @param Request $request
     * @return Response
     */
    public function resetPassword(Request $request){
        $uuid = (string) Str::uuid();
        $email = new PasswordResetEmail;
      
        try {
            Mail::to('corellasanchez@gmail.com')->send($email);
        } catch (Exception $e) {
           dd($e);

            return false;
        }
        return response()->json($uuid);
    }
}
