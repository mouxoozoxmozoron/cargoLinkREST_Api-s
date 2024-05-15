<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        try {
            //code...
            $user = User::where('email', $request->input('email'))->first();

            if ($user && Hash::check($request->input('password'), $user->password)) {
                //Delete old  user tokens if exists
                $user->tokens()->delete();
                //Generate user token using sunctum
                $token = $user->createToken('user-token')->plainTextToken;
                $logedin_user = User::with('userType')->where('email', $request->input('email'))->get();
                return response()->json(
                    [
                        'user' => $logedin_user,
                        'token' => $token,
                    ],
                    200,
                );
            } else {
                return response()->json(['error' => 'Invalid Credentials'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage(),
                    'message' => 'something went wrong in authentication controller',
                ],
                500,
            );
            //throw $th;
        }
    }

    public function logout($userId)
    {
        $user = User::findOrFail($userId);
        //Delete user tokens
        $user->tokens()->delete();

        return response()->json(['message' => $user['UserName'] . ', You Logged out successfully'], 200);
    }
}
