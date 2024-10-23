<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('Truck_Ordering_app')->plainTextToken;
        $success['name'] =  $user->name;

        $response = [
            'status' => 200,
            'data' => $success
        ];
        return response()->json($response);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users,email',  // Ensure email exists in users table
            'password' => 'required|string',  // Password is required
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Truck_Ordering_app')->plainTextToken;
            $success['name'] = $user->name;

            // Successful login response
            return response()->json([
                'status' => 200,
                'data' => $success
            ]);
        } else {
            // If authentication fails
            return response()->json(['errors' => ['general' => 'Invalid credentials. Please try again.']], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user(Request $request)
    {
        // Check if the user is authenticated
        if (!$request->user()) {
            $response = [
                'status' => 203,
                'message' => 'User not found'
            ];
            return response()->json($response);
        }
        $response = [
            'status' => 200,
            'data' => $request->user()
        ];
        return response()->json($response);
    }
}
