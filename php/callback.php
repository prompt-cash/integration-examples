<?php
// This file gets called when the payment status changes (paid or expired).
require_once 'config.php';
require_once 'functions.php';

// The content type to respond is ignored by Prompt.Cash but you should return HTTP Status Code 200
header('Content-Type: text/plain; charset=UTF-8');

// Read the application/json POST data.
// Keep the raw body: the signature is computed over the exact bytes Prompt.Cash sent.
// Afterwards you can access JSON variables like $post['payment']['status']
// similar to $_POST for url-encoded form data.
$rawBody = file_get_contents('php://input');
$post = json_decode($rawBody, true);

if (empty($post) || !is_array($post)) {
    echo "no data received";
    return;
}

// prevent spoofing: only trust callbacks signed with your secret token
if (!isValidPromptCashCallback($rawBody, $post, $secretToken)) {
    http_response_code(403);
    echo "invalid signature";
    return;
}
echo "ok"; // any response is fine (ignored by Prompt.Cash)

// check if the payment is complete
if ($post['payment']['status'] === 'PAID') {
    // Payment complete. Update your database and ship your order.
}
else if ($post['payment']['status'] === 'EXPIRED') {
    // The customer did not pay in time. You can cancel this order or send him a new payment link.
}

// Write the callback JSON to a file for debugging. You can remove this for production.
unset($post['token']); // never write your secret token to a (public) file
if (file_put_contents("./callback-payment.json", json_encode($post)) === false)
    echo "error writing callback file";
else
    echo "written callback";
?>
