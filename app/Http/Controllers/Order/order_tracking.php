<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class order_tracking extends Controller
{
    //  update to confirm the orderreceiver status
    public function Confirm_order(Request $request, $order_id)
    {
        try {
            //code...
            DB::beginTransaction();
            if (Auth::user()->user_type_id != 1) {
                return response()->json(
                    [
                        'message' => 'you cant use this action',
                    ],
                    401,
                );
            }

            // Retrieve the order with the given order_id
            $order = Order::find($order_id);

            // Check if the order exists
            if (!$order) {
                return response()->json(
                    [
                        'message' => 'Order not found.',
                    ],
                    404,
                );
            }

            // Update the status attribute
            $order->status = $order->status == 0 ? 1 : 0;
            $order->save();
            DB::commit();
            // Return a response indicating success
            return response()->json(
                [
                    'message' => 'Order status updated successfully.',
                ],
                200,
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'errpr' => 'there was an error while trying to update this order status',
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    //CANCELLING OR POSITIONING AN ORDER
    public function position_order(Request $request, $order_id)
    {
        try {
            DB::beginTransaction();
            //code...
            if (Auth::user()->user_type_id != 1) {
                return response()->json(
                    [
                        'message' => 'you cant use this action',
                    ],
                    401,
                );
            }

            $order = Order::find($order_id);

            if (!$order) {
                return response()->json(
                    [
                        'message' => 'Order not found.',
                    ],
                    404,
                );
            }

            $order->position = $order->position == 0 ? 1 : 0;
            $order->save();
            DB::commit();

            return response()->json(
                [
                    'message' => 'Order positon updated successfully.',
                ],
                200,
            );
        } catch (\Exception $e) {
            //throw $th;
            DB::rollback();
            return response()->json([
                'nessage' => $e->getMessage(),
                'error' => 'there was an error while order positioning',
            ]);
        }
    }
}
