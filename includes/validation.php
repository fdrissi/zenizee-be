<?php
/**
 * Input validation middleware.
 * Validates and sanitizes incoming request data.
 * Exits with JSON error if validation fails.
 */

require_once __DIR__ . '/response.php';

function validate_booking_input($input) {
    if (!$input || !is_array($input)) {
        json_error("Invalid request body");
    }

    $required = [
        'uid', 'eid', 'type', 'typeid', 'price',
        'subtotal', 'total_ticket', 'total_amt',
        'tax', 'sponsore_id', 'p_method_id', 'plimit'
    ];

    $missing = [];
    foreach ($required as $field) {
        if (!isset($input[$field]) || $input[$field] === '' || $input[$field] === null) {
            $missing[] = $field;
        }
    }
    if (!empty($missing)) {
        json_error("Missing fields: " . implode(", ", $missing));
    }

    return [
        'uid'          => intval($input['uid']),
        'eid'          => intval($input['eid']),
        'type'         => $input['type'],
        'typeid'       => intval($input['typeid']),
        'price'        => $input['price'],
        'subtotal'     => $input['subtotal'],
        'cou_amt'      => $input['cou_amt'] ?? '0',
        'total_ticket' => intval($input['total_ticket']),
        'total_amt'    => $input['total_amt'],
        'tax'          => $input['tax'],
        'sponsore_id'  => intval($input['sponsore_id']),
        'wall_amt'     => $input['wall_amt'] ?? '0',
        'p_method_id'  => $input['p_method_id'],
        'plimit'       => intval($input['plimit']),
    ];
}

function validate_stripe_input($input) {
    $required = ['card_number', 'exp_month', 'exp_year', 'cvc', 'amount'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            json_error("Missing card field: $field");
        }
    }

    return [
        'card_number' => $input['card_number'],
        'exp_month'   => $input['exp_month'],
        'exp_year'    => $input['exp_year'],
        'cvc'         => $input['cvc'],
        'custName'    => $input['custName'] ?? '',
        'custEmail'   => $input['custEmail'] ?? '',
        'amount'      => floatval($input['amount']),
    ];
}
