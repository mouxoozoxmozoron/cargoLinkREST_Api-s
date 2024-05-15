<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\profile_update_request;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\FileTrait;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class user_controller extends Controller
{
    use FileTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::get();
            if ($users->isEmpty()) {
                return response()->json(
                    [
                        'message' => 'user not found',
                    ],
                    401,
                );
            }

            return response()->json(
                [
                    'users' => $users,
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => 'error occured during fetching user',
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            //code...
            $user = User::with('userType')->findOrfail($id);
            if (!$user) {
                # code...
                return response()->json(
                    [
                        'message' => 'user not found',
                    ],
                    404,
                );
            }

            return response()->json(['user' => $user], 200);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => 'user not found',
                ],
                404,
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(profile_update_request $request, string $id)
    {
        try {
            //code...
            $validatedData = $request->validated();
            $user = User::findOrFail($id);
            if ($request->has('profile_image')) {
                Storage::delete($user->profile_image);

                $photo_string = $validatedData['profile_image'];
                $profile_photo_url = $this->storeBase64File($photo_string, 'Files/profile_photo');
                $validatedData['profile_image'] = $profile_photo_url;
            }
            $user->update($validatedData);
            return response()->json(
                [
                    'message' => 'user updated succesfull',
                ],
                200,
            );
        } catch (ValidationException $e) {
            // Log::error('Error occurred during company update: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (Exception $e) {
            // Log::error('Error occurred during company update: ' . $e->getMessage());
            return response()->json(['error' => 'user update failed.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(
                [
                    'message' => 'User not found.',
                ],
                404,
            );
        }
        $user->delete();
        return response()->json(
            [
                'message' => 'Account deleted successfully.',
            ],
            200,
        );
    }
}
