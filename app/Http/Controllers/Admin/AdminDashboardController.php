<?php

namespace App\Http\Controllers;

use App\Models\Order; // Your Order model
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function showOrders()
    {
        $orders = Order::all(); // Retrieve all orders
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        // Optionally send email/SMS notification here

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}

