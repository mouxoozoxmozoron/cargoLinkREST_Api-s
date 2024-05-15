<?php

namespace App\Http\Controllers\API\transport_agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\transportation_agent_update;
use App\Http\Requests\Users\transport_agent_creation;
use Illuminate\Http\Request;
use App\Models\Transportation_company;
use App\Traits\FileTrait;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class transportation_agent_controller extends Controller
{
    use FileTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(transport_agent_creation $request)
    {
        try {
            $validatedData = $request->validated();

            // Image processing for agent logo
            $agent_image_string = $validatedData['agent_logo'];
            $agent_image_url = $this->storeBase64File($agent_image_string, 'Files/agent_logo_images');
            $validatedData['agent_logo'] = $agent_image_url;

            $transportation_agent = [
                'user_id' => Auth::user()->id,
                'name' => $validatedData['name'],
                'bank_acount_number' => $validatedData['bank_acount_number'],
                'bank_type' => $validatedData['bank_type'],
                'location' => $validatedData['location'],
                'company_category' => $validatedData['company_category'],
                'routes' => $validatedData['routes'],
                'email' => $validatedData['email'],
                'contact' => $validatedData['contact'],
                'working_day' => $validatedData['working_day'],
                'agent_logo' => $agent_image_url,
            ];
            Transportation_company::create($transportation_agent);
            return response()->json(
                [
                    'message' => 'company created succesfully',
                ],
                201,
            );
        } catch (ValidationException $e) {
            // Handle validation errors
            Log::error('Error occurred during company creation: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (Exception $e) {
            // Handle any other exceptions
            Log::error('Error occurred during company creation: ' . $e->getMessage());
            return response()->json(['error' => 'company creation failed.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $transportation_company = Transportation_company::with('user')->findOrFail($id);

            return response()->json(
                [
                    'message' => 'Transportation company found',
                    'company' => $transportation_company,
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => 'Transportation company not found',
                    'message' => $e->getMessage(),
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
    public function update(transportation_agent_update $request, $id)
    {
        try {
            $validatedData = $request->validated();

            $company = Transportation_company::findOrFail($id);

            if ($request->has('agent_logo')) {
                Storage::delete($company->agent_logo);

                $agent_image_string = $validatedData['agent_logo'];
                $agent_image_url = $this->storeBase64File($agent_image_string, 'Files/agent_logo_images');
                $validatedData['agent_logo'] = $agent_image_url;
            }

            $company->update($validatedData);

            return response()->json(['message' => 'Company updated successfully'], 200);
        }
        catch (ValidationException $e) {
            Log::error('Error occurred during company update: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 422);
        }
        catch (Exception $e) {
            Log::error('Error occurred during company update: ' . $e->getMessage());
            return response()->json(['error' => 'Company update failed.', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
