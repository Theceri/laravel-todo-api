<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller 
{
    public function login(Request $request)
    {
        // using the Guzzle Http client for making requests with PHP, having installed it with composer (composer require guzzlehttp/guzzle)
        $http = new \GuzzleHttp\Client;

        try {
            // the endpont is hard coded for now, but shall be moved to environment variables later
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    // grant_type, client_id, and client_secret are hard coded for now, but shall be moved to environment variables later
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);

            return $response->getBody();

            // $x = array (
            //     'website' =>
            //     array (
            //       'domain' => 'wtools.io',
            //       'title' => 'Online Web Tools',
            //     ),
            // );

            // return json_encode($x);


        } catch (\GuzzleHttp\Exception\BadResponseException $e) {

            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }

            return response()->json('Something went wrong on the server.', $e->getCode());

            // $x = array (
            //     'website' =>
            //     array (
            //       'domain' => 'wtools.io',
            //       'title' => 'Online Web Tools',
            //     ),
            // );

            // return json_encode($x);

        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6', // removed |confirmed because for now I am just going to fill in one password without the need for confirming it on the form
        ]);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function($token, $key){
            // we could also have done $token->revoke() if we want to just revoke the token (change the value of the 'revoked' column on the table 'oauth_access_tokens' table from 0 to 1 to mark the token as revoked) and not delete it from the tokens table, but in this case we choose to delete the token
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
