<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Book;
use App\User;
// use Illuminate\Support\Facades\Route;
// use Laravel\Passport\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // private $client;

    // public function __construct(){
    //     $this->client = Client::find(1);
    // }

    public function login(Request $request) {
        return $this->validateLogin($request);
        // if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
        //     $user = Auth::user();
        //     $tokenResult = $user->createToken('Personal Access Token');
        //     $token = $tokenResult->token;
        //     $success_response = array(
        //          'user_id' => $tokenResult->token->user_id,
        //          'tokenType' => 'Bearer',
        //          'accessToken' => $tokenResult->accessToken,
        //          'expiresIn' => $tokenResult->token->expires_at,
        //      );
        //     return response()->json($success_response);
        // }
        // else{
        //   $fail_response = array(
        //      'tokenType' => 'Wrong email or password!!!',
        //    );
        //    return response()->json($fail_response);
        // }
    }

    public function validateLogin(Request $request) {
         $user = User::where('email', $request->email)->first();
         if (!$user) {
              $fail_response = array(
                  'status' => 'fail',
                  'email' => 'Wrong Email. Cannot find the user with this email.',
              );
              return response()->json($fail_response);
         } else if (!(Hash::check($request->password, $user->password))) {
              $fail_response = array(
                  'status' => 'fail',
                  'password' => 'Wrong password! Please try again.',
               );
               return response()->json($fail_response);
         } else {
              $success_response = array(
                  'status' => 'success',
                  'user_id' => $user->id,
               );
              return response()->json($success_response);
         }
    }

    public function signup() {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8',
            'password_confirm' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $fail_response = array(
                'status' => 'fail',
            );
            if ($validator->errors()->get('name') != null)
                $fail_response['name'] = $validator->errors()->get('name')[0];
            if ($validator->errors()->get('email') != null)
                $fail_response['email'] = $validator->errors()->get('email')[0];
            if ($validator->errors()->get('password') != null)
                $fail_response['password'] = $validator->errors()->get('password')[0];
            if ($validator->errors()->get('password_confirm') != null)
                $fail_response['password_confirm'] = $validator->errors()->get('password_confirm')[0];
            return response()->json($fail_response);
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'role' => 0,
        ]);

        $success_response = array(
            'status' => 'success',
            'user_id' => $user->id,
         );
        return response()->json($success_response);

    }

    public function getUser($id) {
        $user = User::find($id);
        return response()->json($user);
    }

}
