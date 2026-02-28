<?php
/**
 * Stripe Payment Endpoint
 *
 * Two modes:
 * 1. Payment only (wallet top-up): card fields only → charge → return transaction_id
 * 2. Atomic booking: card + booking fields → validate → charge → book → notify
 */

require_once __DIR__ . '/../filemanager/evconfing.php';
require_once __DIR__ . '/../includes/response.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../includes/stripe.php';

cors_headers();

try {
    $input = json_decode(file_get_contents('php://input'), true);

    // 1. Validate card
    $card = validate_stripe_input($input);

    // 2. Detect mode: booking fields present?
    $isBooking = !empty($input['uid']) && !empty($input['eid']);

    // 3. Charge
    $keys     = is_demo_mode() ? ['secret' => ''] : stripe_get_keys($evmulti);
    $currency = strtolower($set['currency_code'] ?? 'usd');
    $charge   = stripe_charge($card, $keys['secret'], $currency);

    // 4. If booking mode → atomic book + notify
    if ($isBooking) {
        require_once __DIR__ . '/../includes/booking.php';
        require_once __DIR__ . '/../includes/notifications.php';

        $booking = validate_booking_input($input);
        $result  = execute_booking($booking, $charge['transaction_id'], $evmulti);

        if (!$result || !$result['order_id']) {
            stripe_refund($charge['charge_id'], $keys['secret']);
            json_error("Booking insert failed. Payment has been refunded.");
        }

        send_booking_notifications($result, $booking, $set);

        $word = ($booking['total_ticket'] == 1) ? "Ticket" : "Tickets";
        json_success("Book $word Successfully!!!", [
            "Transaction_id" => $charge['transaction_id'],
            "wallet"         => $result['wallet'],
            "order_id"       => $result['order_id'],
        ]);
    }

    // 5. Payment only (wallet top-up, etc.)
    json_success("Payment Successful!", [
        "Transaction_id" => $charge['transaction_id'],
    ]);

} catch (Exception $e) {
    json_error("Payment failed: " . $e->getMessage());
}
