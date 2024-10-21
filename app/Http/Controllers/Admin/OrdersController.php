<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OrdersController extends Controller
{
    use Searchable;
    public function index() : View
    {
        $query = Order::query();
        $this->search($query, ['pickup_location', 'delivery_location','size','weight','status']);
        $orders = $query->orderBy('id', 'DESC')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }


    public function edit(string $id) : View
    {
        $order = Order::findOrFail($id);

        return view('admin.orders.edit', compact(
            'order',
        ));
    }

    function changeStatus(Request $request, string $id)  {
        $request->validate([
            'status' => ['required', 'string','in:pending,in_progress,delivered,canceled']
        ]);

        // dd($request->all());
        $job = Order::findOrFail($id);
        // dd($job);
        $status = $request->status;
        $job->status = $status;
        $job->save();
        Notify::updatedNotification();
        return to_route('admin.orders.index');
    }
}
