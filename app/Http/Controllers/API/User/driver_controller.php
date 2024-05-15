<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\driver_registration_request;
use App\Models\Company_Worker;
use App\Models\Driver;
use App\Models\Transportation_company;
use App\Models\User;
use App\Traits\FileTrait;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class driver_controller extends Controller
{
    use FileTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $company = Transportation_company::where('user_id', Auth::user()->id)->firstOrFail();
            $companyId = $company->id;

            $drivers = Driver::with('user')->where('transportation_company_id', $companyId)->get();

            if ($drivers->isEmpty()) {
                return response()->json(
                    [
                        'message' => 'No drivers found for this company',
                    ],
                    404,
                );
            }

            return response()->json(
                [
                    'message' => 'Drivers found',
                    'driver_list' => $drivers,
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'An error occurred while fetching drivers',
                    'error' => $e->getMessage(),
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
    public function store(driver_registration_request $request)
    {
        try {
            Log::info('Logged-in user ID: ' . Auth::user()->id);
            DB::beginTransaction();
            $userData = $request->validated();

            // Hash the password
            $userData['password'] = Hash::make($userData['password']);

            // // Store the profile photo

            if ($request->has('profile_image')) {
                $photo_string = $userData['profile_image'];
                $profile_photo_url = $this->storeBase64File($photo_string, 'Files/profile_photo');
                $userData['profile_image'] = $profile_photo_url;
            }

            $userData['user_type_id'] = 2; //2 is an id for driver user
            $user = User::create($userData);

            //creating driver other information by attaching iformation to driver and workers table
            $created_driver_id = $user->id;
            //get usr type id
            $created_driver_user_type = $user->user_type_id;
            //get company id
            $transportation_company = Transportation_company::where('user_id', Auth::user()->id)->first();
            if (!$transportation_company) {
                return response()->json(['error' => 'Transportation company not found for the authenticated user'], 404);
            }
            $transportation_company_id = $transportation_company->id;

            //create driver
            $driver = new Driver([
                'user_id' => $created_driver_id,
                'transportation_company_id' => $transportation_company_id,
            ]);

            $worker = new Company_Worker([
                'user_id' => $created_driver_id,
                'transportation_company_id' => $transportation_company_id,
                'user_type_id' => $created_driver_user_type,
            ]);
            //save the driver and asign him as a worker
            $driver->save();
            $worker->save();
            DB::commit();

            return response()->json(
                [
                    'user' => $user,
                    'message' => 'driver created succesfully',
                ],
                201,
            );
        } catch (ValidationException $e) {
            Db::rollBack();
            // Log::error('Error occurred during driver registration: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (Exception $e) {
            Db::rollBack();
            return response()->json(['error' => 'driver registration failed.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $company = Transportation_company::where('user_id', Auth::user()->id)->firstOrFail();
            $companyId = $company->id;

            $drivers = Driver::with('user', 'company')->where('transportation_company_id', $companyId)->where('id', $id)->get();

            if ($drivers->isEmpty()) {
                return response()->json(
                    [
                        'message' => 'No driver found for this company',
                    ],
                    404,
                );
            }

            return response()->json(
                [
                    'message' => 'Driver found',
                    'driver_list' => $drivers,
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'An error occurred while fetching driver',
                    'error' => $e->getMessage(),
                ],
                500,
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
