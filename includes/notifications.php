<?php
/**
 * Notification service — OneSignal push + DB notifications.
 * Fire-and-forget: failures never block the booking response.
 */

require_once __DIR__ . '/../filemanager/event.php';

function send_onesignal($app_id, $auth_key, $filters, $content, $heading, $data = []) {
    $fields = json_encode([
        "app_id"   => $app_id,
        "data"     => $data,
        "filters"  => $filters,
        "contents" => $content,
        "headings" => $heading,
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json; charset=utf-8",
        "Authorization: Basic " . $auth_key,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch);
    curl_close($ch);
}

function send_booking_notifications($booking_result, $booking, $set) {
    $oid  = $booking_result['order_id'];
    $name = $booking_result['user_name'];
    $uid  = $booking['uid'];
    $eid  = $booking['eid'];
    $sid  = $booking['sponsore_id'];
    $ts   = $booking_result['timestamp'];

    // Push to user
    send_onesignal(
        $set['one_key'], $set['one_hash'],
        [["field" => "tag", "key" => "user_id", "relation" => "=", "value" => $uid]],
        ["en" => "$name, Your Ticket Booking #$oid Successfully."],
        ["en" => "Book Ticket Successfully!!"],
        ["order_id" => $oid, "type" => "normal"]
    );

    // Push to organizer
    send_onesignal(
        $set['s_key'], $set['s_hash'],
        [["field" => "tag", "key" => "orag_id", "relation" => "=", "value" => $sid]],
        ["en" => "Ticket Booking Event #$eid Received."],
        ["en" => "Event Book Ticket Received!!"],
        ["order_id" => $oid, "type" => "normal"]
    );

    // DB notification for user
    $h = new Event();
    $h->evmultiinsertdata_Api(
        ["uid", "datetime", "title", "description"],
        ["$uid", "$ts", "Book Ticket Successfully!!", "Book Ticket #$oid Successfully."],
        "tbl_notification"
    );

    // DB notification for organizer
    $h2 = new Event();
    $h2->evmultiinsertdata_Api(
        ["orag_id", "datetime", "title", "description"],
        ["$sid", "$ts", "Book Ticket Received!!", "Book Ticket Event#$eid Received."],
        "tbl_snotification"
    );
}
