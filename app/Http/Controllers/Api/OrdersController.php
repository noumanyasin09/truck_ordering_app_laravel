<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use App\Events\OrderPlaced;
use App\Events\OrderRequest;
use App\Events\SendNotification;

class OrdersController extends BaseController
{
    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pickup_location' => 'required|string|nullable',
            'delivery_location' => 'required|string|nullable',
            'size' => 'required|string',
            'weight' => 'required|numeric',
            'pickup_time' => 'required|date',
            'delivery_time' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = Order::create([
            'user_id' => $request->user()->id,
            'pickup_location' => $request->pickup_location,
            'delivery_location' => $request->delivery_location,
            'size' => $request->size,
            'weight' => $request->weight,
            'pickup_time' => $request->pickup_time,
            'delivery_time' => $request->delivery_time
        ]);

        // Prepare the notification data
    $notificationData = [
        'message' => 'A new order request is created',
        'order_id' => $order->id,
        'user_name' => auth()->user()->name,
    ];

        // Broadcast the SendNotification event
    broadcast(new SendNotification($notificationData))->toOthers();

        if ($order) {
            $response = [
                'status' => 200,
                'data' => $order
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 400
            ];
            return response()->json($response);
        }
    }

    public function getOrders(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->get();
        if ($orders->isEmpty()) {
            $response = [
                'status' => 203
            ];
            return response()->json($response);
        } else {
            $response = [
                'status' => 200,
                'data' => $orders
            ];
            return response()->json($response);
        }
    }

    public function updateOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:orders,id',
            'status' => 'required|string|in:pending,in_progress,delivered,canceled',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $order = Order::findOrFail($request->id);
        $order->status = $request->status;
        $order->save();

        return response()->json(['order' => $order]);
    }
}
