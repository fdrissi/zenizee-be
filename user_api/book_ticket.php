<?php
/**
 * Generic Booking Endpoint (for external payment gateways)
 *
 * Called AFTER payment is already completed externally
 * (Razorpay, PayPal, FlutterWave, wallet-only, free tickets, etc.)
 *
 * Flow: Validate → Book → Notify
 */

require_once __DIR__ . '/../filemanager/evconfing.php';
require_once __DIR__ . '/../includes/response.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../includes/booking.php';
require_once __DIR__ . '/../includes/notifications.php';

header("Content-type: application/json");

$input = json_decode(file_get_contents('php://input'), true);

// 1. Validate
$booking        = validate_booking_input($input);
$transaction_id = $input['transaction_id'] ?? '';

if ($transaction_id === '' || $transaction_id === null) {
    json_error("Something Went wrong  try again !");
}

// 2. Book
$result = execute_booking($booking, $transaction_id, $evmulti);

if (!$result || !$result['order_id']) {
    json_error("Booking failed. Please try again.");
}

// 3. Notify
send_booking_notifications($result, $booking, $set);

// 4. Respond
$word = ($booking['total_ticket'] == 1) ? "Ticket" : "Tickets";
json_success("Book $word Successfully!!!", [
    "wallet"   => $result['wallet'],
    "order_id" => $result['order_id'],
]);
