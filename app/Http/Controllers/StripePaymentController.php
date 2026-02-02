<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class StripePaymentController extends Controller
{
    public function index()
    {
        return view('admin.stripe.pay_fee');
    }

    /**
     * Create PaymentIntent (AJAX)
     */
    public function createIntent(Request $request)
    {
        $user = auth()->user();
        $amount = 100; // fixed fee (in dollars)

        try {
            if (!$user->stripe_id) {
                $user->createAsStripeCustomer();
            }

            $intent = $user->createSetupIntent();

            return response()->json([
                'client_secret' => $intent->client_secret
            ]);
        } catch (Exception $e) {
            server_logs('Stripe Intent Error', $e->getMessage(), __METHOD__);

            return response()->json([
                'error' => 'Unable to initialize payment.'
            ], 422);
        }
    }

    /**
     * Confirm & charge card (AJAX)
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string'
        ]);

        $user = auth()->user();

        if ($user->payment_completed) {
            return response()->json([
                'error' => 'Payment already completed.'
            ], 409);
        }
        $amount = 100; // dollars

        try {
            $user->addPaymentMethod($request->payment_method);
            $user->updateDefaultPaymentMethod($request->payment_method);

            $charge = $user->charge(
                $amount * 100,
                $request->payment_method
            );

            $paymentMethod = $user->defaultPaymentMethod();

            $user->update([
                'paid_amount'    => $amount,
                'card_brand'     => $paymentMethod->card->brand,
                'card_last_four' => $paymentMethod->card->last4,
                "role" => "company",
                "payment_completed" => true,
            ]);

            return response()->json([
                'success' => true,
                'redirect' => route('index')
            ]);
        } catch (Exception $e) {
            server_logs('Stripe Charge Error', $e->getMessage(), __METHOD__);

            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
