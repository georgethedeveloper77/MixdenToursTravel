<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $mustVerify = setting_item('enable_verify_email_register_user');
        if ($mustVerify == 1) {
            if (auth()->check() and ($request->user() instanceof MustVerifyEmail &&
                    !$request->user()->hasVerifiedEmail())) {
                if (!$request->user()->hasPermissionTo('dashboard_access')) {
                    return $request->expectsJson()
                        ? abort(403, 'Your email address is not verified.')
                        : Redirect::route('verification.notice');
                }

            }
        }

        return $next($request);
    }
}
