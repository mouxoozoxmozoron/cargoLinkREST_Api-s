<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transportation_company;
use App\Models\Company_Worker;
use App\models\User;
use App\Models\Company_category;

class home_controller extends Controller
{
    public function home()
    {
        try {
            //code...
            $transportation_companies = Transportation_company::with("user")->get();
            if ($transportation_companies->isEmpty()) {
                # code...
                return response()->json([
                    'message' => 'No agent yet',
                ], 404);
            } else {
                return response()->json(
                    [
                        'transportation_companies' => $transportation_companies,
                    ],
                    200,
                );
            }
        } catch (\Exception $e) {
            //throw $th;
            return response()->json(
                [
                    'message' => 'an error occured in home controller',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
