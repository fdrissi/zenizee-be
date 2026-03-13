<?php
/**
 * Stripe API wrapper — charge and refund via cURL.
 * Handles demo mode: if DEMO_MODE=true, returns fake success.
 */

function is_demo_mode() {
    return ($_ENV['DEMO_MODE'] ?? 'false') === 'true';
}

function stripe_get_keys($evmulti) {
    $row = $evmulti->query("SELECT attributes FROM tbl_payment_list WHERE id=2")->fetch_assoc();
    if (!$row) {
        throw new Exception("Stripe payment method not found in database");
    }
    $keys = explode(",", $row['attributes']);
    return [
        'publishable' => trim($keys[0] ?? ''),
        'secret'      => trim($keys[1] ?? ''),
    ];
}

function stripe_charge($card, $secret_key, $currency) {
    if (is_demo_mode()) {
        $demo_id = 'demo_' . bin2hex(random_bytes(12));
        return [
            'charge_id'      => $demo_id,
            'transaction_id' => $demo_id,
        ];
    }

    // Step 1: Create token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/tokens");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ":");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'card[number]'    => $card['card_number'],
        'card[exp_month]' => $card['exp_month'],
        'card[exp_year]'  => $card['exp_year'],
        'card[cvc]'       => $card['cvc'],
    ]));
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);

    if (!isset($data['id'])) {
        throw new Exception($data['error']['message'] ?? 'Token creation failed');
    }

    // Step 2: Create charge
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/charges");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ":");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'source'      => $data['id'],
        'amount'      => round($card['amount'] * 100),
        'currency'    => $currency,
        'description' => "Payment by " . $card['custName'] . " (" . $card['custEmail'] . ")",
    ]));
    $response = curl_exec($ch);
    $charge = json_decode($response, true);
    curl_close($ch);

    if (!isset($charge['id'])) {
        throw new Exception($charge['error']['message'] ?? 'Charge creation failed');
    }

    return [
        'charge_id'      => $charge['id'],
        'transaction_id' => $charge['id'],
    ];
}

function stripe_refund($charge_id, $secret_key) {
    if (is_demo_mode()) {
        return ['id' => 'demo_refund_' . bin2hex(random_bytes(8))];
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.stripe.com/v1/refunds");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_USERPWD, $secret_key . ":");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['charge' => $charge_id]));
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}
