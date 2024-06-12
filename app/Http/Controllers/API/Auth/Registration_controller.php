<?php
namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRegistrationRequest;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

//let log to troubleshoot
use Illuminate\Support\Facades\Log;


class Registration_controller extends Controller
{
    use FileTrait;

//UserRegistrationRequest

public function register(UserRegistrationRequest $request) {
    try {
        $userData = $request->validated();

        // Hash the password
        $userData['password'] = Hash::make($userData['password']);

        // Store the profile photo
        $photo_string = $userData['profile_image'];
        $profile_photo_url = $this->storeBase64File($photo_string, 'Files/profile_photo');
        $userData['profile_image'] = $profile_photo_url;
        $userData['user_type_id'] =3;

        // Create the user
        $user = User::create($userData);

        // Create user token for authentication using Sanctum
        $token = $user->createToken('user-token')->plainTextToken;

        // Return success response
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }
    catch (ValidationException $e) {
        // Handle validation errors
        Log::error('Error occurred during user registration: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 422);
    }
    catch (Exception $e) {
        // Handle any other exceptions
        Log::error('Error occurred during user registration: ' . $e->getMessage());
        return response()->json(['error' => 'User registration failed.', 'message' => $e->getMessage()], 500);
    }
}


}
