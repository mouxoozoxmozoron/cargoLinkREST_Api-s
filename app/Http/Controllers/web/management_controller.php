<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\View\Components\script;
use Illuminate\Http\Request;

class management_controller extends Controller
{
    public function dashboard()
    {
        return view('screens/management/home_dashboard');
    }

    public function companyorder(Request $req)
    {
        $cid = $req->id;
        $order = Order::with('user')->where('transportation_companies_id', $cid)->get();
        if ($order->isnotEmpty()) {
            return view('screens/management/comapny_order_screen', [
                'companyorders' => $order,
            ]);
        } else {
            return response("<script>
                alert('No order available');
                window.location.href = 'dashboard';
            </script>");
        }
    }

    public function deliverorder(REQUEST $req)
    {
        $orderid = $req->id;
        try {
            $order = Order::findOrFail($orderid);

            $order->position = 1;
            $order->save();

            return redirect()->back()->with('success', 'Order updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the order');
        }
    }

    public function deleteorder(REQUEST $req)
    {
        $orderid = $req->id;

        $order = Order::where('id', $orderid)->first();
        if ($order) {
            $order->delete();
            return redirect()->back()->with('success', 'Order deleted successfully');
        }
        return redirect()->back()->with('error', 'Order not found');
    }

    public function editorder(REQUEST $req)
    {
        return response()->json('here from company editing page');
    }
}
