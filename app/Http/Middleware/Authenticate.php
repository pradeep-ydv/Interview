<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            // Check if the user is authenticated
            if(auth()->check()) {
                // If authenticated, redirect to the "admin" route
                return route('admin');
            } else {
                // If not authenticated, redirect to the home page ('/')
                return redirect('/');
            }
        }
    }
}
