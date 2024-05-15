<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\FileTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    use FileTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            //code...
            $order = Order::with('user')->get();
            $order = Order::with('user', 'transportation_company', 'driver.user')->where('user_id', Auth::user()->id)->get();
            if ($order->isEmpty()) {
                # code...
                return response()->json(
                    [
                        'message' => 'no order available',
                    ],
                    401,
                );
            }

            return response()->json(
                [
                    'order' => $order,
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(['message' => getcwd($e)], 500);
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
        try {
            // Validating request data
            $validatedData = $request->validate([
                // 'status' => 'required|integer',
                //destination
                'destination' => 'required|string',
                'driver_id' => 'nullable|integer',
                'transportation_companies_id' => 'required|integer',
                // 'receipt_image' => 'required|string',
                'cargo_image' => 'required|string',
                'quantity' => 'required|string',
            ]);

            // Check for missing fields
            $missingFields = array_diff_key($validatedData, $request->all());
            if (!empty($missingFields)) {
                return response()->json(['error' => 'Missing fields: ' . implode(', ', array_keys($missingFields))], 400);
            }

            // Image processing for receipt
            // $receipt_image_string = $request->input('receipt_image');
            // $receipt_image_url = $this->storeBase64File($receipt_image_string, 'Files/receipt_image');

            // Image processing for cargo
            $cargo_image_string = $request->input('cargo_image');
            $cargo_image_url = $this->storeBase64File($cargo_image_string, 'Files/cargo_image');

            // Modifying post attributes
            $order = [
                'user_id' => Auth::user()->id,
                'position' => 0,
                'status' => 0, // Make sure 'status' is included
                // 'driver_id' => $validatedData['driver_id'],
                'destination' => $validatedData['destination'],
                'transportation_companies_id' => $validatedData['transportation_companies_id'],
                // 'receipt_image' => $receipt_image_url,
                'cargo_image' => $cargo_image_url,
                'quantity' => $validatedData['quantity'],
            ];

            // Creating the order
            Order::create($order);

            return response()->json(['message' => 'Order created successfully'], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (Exception $e) {
            // Log the error
            // Log::error('Error occurred during order creation: ' . $e->getMessage());

            // Return a generic error response
            return response()->json(['error' => 'Order creation failed.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            //code...
            $order = Order::with('user', 'transportation_company', 'driver.user')->where('id', $id)->get();
            if ($order->isEmpty()) {
                # code...
                return response()->json(
                    [
                        'message' => 'no order available',
                    ],
                    404,
                );
            }

            return response()->json(
                [
                    'order' => $order,
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(['message' => getcwd($e)], 500);
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
    public function update(Request $request, $id)
    {
        //
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);

            $driver = $request->driver_id;
            if (!$driver) {
                return response()->json(
                    [
                        'message' => 'please. select driver to asign to the order',
                    ],
                    401,
                );
            }
            $order->driver_id = $driver;

            $order->save();
            DB::commit();
            return response()->json(
                [
                    'message' => 'driver asigned succesfully',
                ],
                200,
            );
        } catch (\Throwable $th) {
            // Handle any exceptions
            DB::rollback();
            return response()->json(
                [
                    'error' => 'Failed to asign driver to this order',
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    //
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Retrieve the order with the given ID
        $order = Order::find($id);

        // Check if the order exists
        if (!$order) {
            return response()->json(
                [
                    'message' => 'Order not found.',
                ],
                404,
            );
        }

        // Delete the order
        $order->delete();

        // Return a response indicating success
        return response()->json(
            [
                'message' => 'Order deleted successfully.',
            ],
            200,
        );
    }
}
