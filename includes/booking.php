<?php
/**
 * Booking orchestrator — single source of truth for booking logic.
 *
 * Performs: eligibility checks, unique ticket ID generation,
 * tbl_ticket insert, wallet deduction + wallet_report logging.
 *
 * Does NOT handle: payment processing, notifications, response formatting.
 */

require_once __DIR__ . '/response.php';
require_once __DIR__ . '/../filemanager/event.php';

function check_booking_eligibility($booking, $evmulti) {
    // Event exists?
    $event = $evmulti->query(
        "SELECT title, edate, etime FROM tbl_event WHERE id=" . $booking['eid']
    )->fetch_assoc();
    if (!$event) {
        json_error("Event not found");
    }

    // Event already passed?
    $end_datetime = $event['edate'] . ' ' . $event['etime'];
    if (strtotime($end_datetime) !== false && strtotime($end_datetime) < time()) {
        json_error("This event has already ended.");
    }

    // User exists?
    $user = $evmulti->query(
        "SELECT name FROM tbl_user WHERE id=" . $booking['uid']
    )->fetch_assoc();
    if (!$user) {
        json_error("User not found");
    }

    // Event still bookable?
    $bad_status = $evmulti->query(
        "SELECT id FROM tbl_event WHERE id=" . $booking['eid'] .
        " AND (event_status='Cancelled' OR event_status='Completed' OR status=0)"
    )->num_rows;
    if ($bad_status > 0) {
        json_error("We cannot book your tickets because the event has been cancelled, completed, or unpublished!!");
    }

    // Tickets available?
    $sold = $evmulti->query(
        "SELECT SUM(total_ticket) AS cnt FROM tbl_ticket " .
        "WHERE eid=" . $booking['eid'] .
        " AND typeid=" . $booking['typeid'] .
        " AND ticket_type='Booked'"
    )->fetch_assoc();
    $joined = intval($sold['cnt'] ?? 0);
    $remaining = $booking['plimit'] - $joined;
    if ($remaining < $booking['total_ticket']) {
        json_error("Ticket Slot As You Asked Not Available. Please Refresh And Check Available Seats!!");
    }

    // Wallet sufficient?
    $wallet_row = $evmulti->query(
        "SELECT wallet FROM tbl_user WHERE id=" . $booking['uid']
    )->fetch_assoc();
    $wallet_balance = floatval($wallet_row['wallet']);
    if (floatval($booking['wall_amt']) > 0 && $wallet_balance < floatval($booking['wall_amt'])) {
        json_error("Wallet Balance Not There As Per Booking Refresh One Time Screen!!!", "200", [
            "wallet" => $wallet_row['wallet']
        ]);
    }

    return [
        'event_title'    => $event['title'],
        'user_name'      => $user['name'],
        'wallet_balance' => $wallet_balance,
    ];
}

function generate_ticket_id($evmulti) {
    do {
        $id = "tic_" . bin2hex(random_bytes(14));
        $exists = $evmulti->query(
            "SELECT id FROM tbl_ticket WHERE uniq_id='" .
            $evmulti->real_escape_string($id) . "'"
        )->num_rows;
    } while ($exists > 0);
    return $id;
}

function insert_ticket($booking, $transaction_id, $evmulti) {
    $timestamp = date("Y-m-d H:i:s");
    $uniq_id = generate_ticket_id($evmulti);

    // Get organizer commission
    $comm_row = $evmulti->query(
        "SELECT commission FROM tbl_sponsore WHERE id=" . $booking['sponsore_id']
    )->fetch_assoc();
    $commission = $comm_row['commission'] ?? '0';

    $fields = [
        "p_method_id", "transaction_id", "eid", "type", "price",
        "subtotal", "cou_amt", "total_ticket", "total_amt", "uid",
        "wall_amt", "typeid", "tax", "sponsore_id", "commission",
        "book_time", "uniq_id"
    ];
    $values = [
        $booking['p_method_id'], $transaction_id, $booking['eid'],
        $booking['type'], $booking['price'], $booking['subtotal'],
        $booking['cou_amt'], $booking['total_ticket'], $booking['total_amt'],
        $booking['uid'], $booking['wall_amt'], $booking['typeid'],
        $booking['tax'], $booking['sponsore_id'], $commission,
        $timestamp, $uniq_id
    ];

    $h = new Event();
    $order_id = $h->evmultiinsertdata_Api_Id($fields, $values, "tbl_ticket");

    return ['order_id' => $order_id, 'timestamp' => $timestamp];
}

function deduct_wallet($booking, $order_id, $timestamp, $evmulti) {
    if (floatval($booking['wall_amt']) == 0) {
        return;
    }

    $wallet_row = $evmulti->query(
        "SELECT wallet FROM tbl_user WHERE id=" . $booking['uid']
    )->fetch_assoc();
    $new_balance = floatval($wallet_row['wallet']) - floatval($booking['wall_amt']);

    $h = new Event();
    $h->evmultiupdateData_Api(
        ["wallet" => "$new_balance"],
        "tbl_user",
        "where id=" . $booking['uid']
    );

    $h2 = new Event();
    $h2->evmultiinsertdata_Api(
        ["uid", "message", "status", "amt", "tdate"],
        [$booking['uid'], "Wallet Used in Booking Id#" . $order_id, "Debit", $booking['wall_amt'], $timestamp],
        "wallet_report"
    );
}

/**
 * Execute the complete booking pipeline.
 * Returns associative array on success, or null on insert failure.
 * Calls json_error() and exits on eligibility failures.
 */
function execute_booking($booking, $transaction_id, $evmulti) {
    // Step 1: Eligibility (exits on failure)
    $context = check_booking_eligibility($booking, $evmulti);

    // Step 2: Insert ticket
    $result = insert_ticket($booking, $transaction_id, $evmulti);
    if (!$result['order_id']) {
        return null;
    }

    // Step 3: Wallet deduction
    deduct_wallet($booking, $result['order_id'], $result['timestamp'], $evmulti);

    // Step 4: Read final wallet balance
    $final_wallet = $evmulti->query(
        "SELECT wallet FROM tbl_user WHERE id=" . $booking['uid']
    )->fetch_assoc();

    return [
        'order_id'    => $result['order_id'],
        'timestamp'   => $result['timestamp'],
        'wallet'      => $final_wallet['wallet'],
        'user_name'   => $context['user_name'],
        'event_title' => $context['event_title'],
    ];
}
