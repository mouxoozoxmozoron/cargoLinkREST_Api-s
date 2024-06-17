<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class order_tracking extends Controller
{
    use FileTrait;
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

    public function verify_payment(REQUEST $req)
    {
        try {
            DB::beginTransaction();
            $receipt_image = $req->receipt_image;
            $order_id = $req->order_id;

            $order = Order::find($order_id);

            if (!$order) {
                return response()->json(
                    [
                        'message' => 'Order not found.',
                    ],
                    404,
                );
            }

            // Check if there's an existing receipt image
            if ($order->receipt_image) {
                // Delete the existing receipt image from storage
                Storage::delete($order->receipt_image);
            }

            $receipt_image_string = $req->receipt_image;
            $receipt_image_url = $this->storeBase64File($receipt_image_string, 'Files/receipt_image');

            $order->receipt_image = $receipt_image_url;
            $order->status = 1;
            $order->save();
            DB::commit();

            return response()->json(
                [
                    'message' => 'Payment verified',
                ],
                201,
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
