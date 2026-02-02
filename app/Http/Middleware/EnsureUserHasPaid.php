<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasPaid
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (
            !$user->is_admin &&
            !$user->is_super_admin &&
            $user->payment_completed
        ) {
            return redirect()->route('stripe.payment.page')
                ->with('success', 'Please complete the payment to continue.');
        }

        return $next($request);
    }
}
