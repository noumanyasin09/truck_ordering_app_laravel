<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendEmail;
use App\Models\Order;
use App\Models\User;
use App\Traits\Searchable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use Searchable;

    function __construct()
    {
        // $this->middleware(['permission:'])
    }

    function index()
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $deliveredRequests = Order::where('status', '=', 'delivered')->count();
        $inProcessRequests = Order::where('status', '=', 'in_progress')->count();
        $canceledRequests = Order::where('status', '=', 'canceled')->count();
        $pendingRequests = Order::where('status', '=', 'pending')->count();

        $query = Order::query();
        $this->search($query, ['pickup_location', 'delivery_location', 'size', 'weight', 'status']);
        $orders = $query->orderBy('status', 'DESC')->paginate(20);

        return view('admin.dashboard.index', compact('totalUsers', 'totalOrders', 'deliveredRequests', 'inProcessRequests', 'canceledRequests', 'pendingRequests', 'orders'));
    }

    public function email()
    {
        $users = User::all();

        return view('admin.email.index', compact('users'));
    }

    public function sendEmail(Request $request)
    {

        $request->validate([
            'subject' => ['required', 'string', 'max:300'],
            'email' => ['required', 'email', 'exists:users,email'],
            'message' => ['required', 'string'],
        ]);

         // Get the user input
        $email = $request->input('email');
        $subject = $request->input('subject');
        $message = $request->input('message');

        try{

            // Send the email
        Mail::to($email)->send(new SendEmail($subject, $message));

        // If no failures, return success message
        notify()->success('Email sent successfully!', 'Success!');
        return back();

        } catch(Exception $e){

            // Return an error message
            notify()->error('There was a problem sending the email.'. $e->getMessage(), 'Error!');
            return back();
        }



        // $users = User::all();

        // return view('admin.email.index', compact('users'));
    }
}
