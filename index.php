<?php
require 'vendor/autoload.php';
$stripe = new \Stripe\StripeClient('sk_test_51OfC7RKYr1gbOYbzF7eriNqEISiqqcEmt2eD3zGMv3Hiw4LbUDq07KPTWoLH2QbSSoJHZ9FmGlyXDDaLO1hLUgOK00scQm3MPe');

// Retrieve the amount from POST request
// Make sure you are using the correct key as sent from the app
$amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 1069;

// Use an existing Customer ID if this is a returning customer.
$customer = $stripe->customers->create();
$ephemeralKey = $stripe->ephemeralKeys->create([
  'customer' => $customer->id
], [
  'stripe_version' => '2023-10-16',
]);

$paymentIntent = $stripe->paymentIntents->create([
  'amount' => $amount,
  'currency' => 'eur',
  'customer' => $customer->id,
  'automatic_payment_methods' => ['enabled' => true],
]);

echo json_encode([
  'paymentIntent' => $paymentIntent->client_secret,
  'ephemeralKey' => $ephemeralKey->secret,
  'customer' => $customer->id,
  'publishableKey' => 'pk_test_51OfC7RKYr1gbOYbz3bcanFhFoEnc03s2KWKfSQciP3t2NXLXejvtaZt6KoGGWyN4nkWx7vuUtg4Ob8VFxVRWPEWX00VZIX6RP7'
]);

http_response_code(200);
?>
