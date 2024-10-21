<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Check if the route is for the admin section
        if ($request->is('admin/*')) {
            return route('admin.login'); // Redirect to the admin login route
        }
        return $request->expectsJson() ? null : route('login');
    }
}
