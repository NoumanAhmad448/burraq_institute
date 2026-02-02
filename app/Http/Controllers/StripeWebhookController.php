<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use Exception;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (Exception $e) {

            server_logs('Stripe Webhook Signature Error', $e->getMessage(), __METHOD__);
            return response('Invalid signature', 400);
        }

        switch ($event->type) {

            case 'charge.succeeded':
                $this->handleChargeSucceeded($event->data->object);
                break;

            case 'payment_intent.payment_failed':
                server_logs('Stripe Payment Failed', json_encode($event->data->object), __METHOD__);
                break;
        }

        return response('Webhook handled', 200);
    }

    protected function handleChargeSucceeded($charge)
    {
        $stripeCustomerId = $charge->customer;

        $user = \App\Models\User::where('stripe_id', $stripeCustomerId)->first();

        if (!$user || $user->payment_completed) {
            return;
        }

        $user->update([
            'paid_amount'       => $charge->amount / 100,
            'payment_completed' => true,
            'card_brand'        => $charge->payment_method_details->card->brand ?? null,
            'card_last_four'    => $charge->payment_method_details->card->last4 ?? null,
        ]);
    }
}
