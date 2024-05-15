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
        // If the request expects JSON, return null to prevent redirection
        if ($request->expectsJson()) {
            return null;
        }

        // For non-JSON requests, redirect to the login route
        //return route('login');
       abort(401, 'Login to acces these services');


    }
}
