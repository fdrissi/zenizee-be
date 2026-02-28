<?php
/**
 * Atomic Stripe Payment + Booking
 *
 * Flow: Validate → Charge → Book → Notify
 * If booking fails after charge: auto-refund.
 */

require_once __DIR__ . '/../filemanager/evconfing.php';
require_once __DIR__ . '/../includes/response.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../includes/stripe.php';
require_once __DIR__ . '/../includes/booking.php';
require_once __DIR__ . '/../includes/notifications.php';

cors_headers();

try {
    $input = json_decode(file_get_contents('php://input'), true);

    // 1. Validate
    $booking = validate_booking_input($input);
    $card    = validate_stripe_input($input);

    // 2. Pre-check eligibility (before charging)
    check_booking_eligibility($booking, $evmulti);

    // 3. Charge
    $keys     = is_demo_mode() ? ['secret' => ''] : stripe_get_keys($evmulti);
    $currency = strtolower($set['currency_code'] ?? 'usd');
    $charge   = stripe_charge($card, $keys['secret'], $currency);

    // 4. Book (with refund safety net)
    $result = execute_booking($booking, $charge['transaction_id'], $evmulti);

    if (!$result || !$result['order_id']) {
        stripe_refund($charge['charge_id'], $keys['secret']);
        json_error("Booking insert failed. Payment has been refunded.");
    }

    // 5. Notify (fire-and-forget)
    send_booking_notifications($result, $booking, $set);

    // 6. Respond
    $word = ($booking['total_ticket'] == 1) ? "Ticket" : "Tickets";
    json_success("Book $word Successfully!!!", [
        "Transaction_id" => $charge['transaction_id'],
        "wallet"         => $result['wallet'],
        "order_id"       => $result['order_id'],
    ]);

} catch (Exception $e) {
    json_error("Payment failed: " . $e->getMessage());
}
