<?php
// This file gets called when the payment status changes (paid or expired).

// The content type to respond is ignored by Prompt.Cash but you should return HTTP Status Code 200
header('Content-Type: text/plain; charset=UTF-8');

// Read the application/json POST data.
// Afterwards you can access JSON variables like $post['payment']['status']
// similar to $_POST for url-encoded form data.
$post = json_decode(file_get_contents('php://input'), true);

if (empty($post)) {
    echo "no data received";
    return;
}

// check if the payment is complete
if ($post['payment']['status'] === 'PAID')
    echo "Payment complete. Update your database and ship your order.";
else if ($post['payment']['status'] === 'EXPIRED')
    echo "The customer did not pay in time. You can cancel this order or send him a new payment link.";

// Write the callback JSON to a file for debugging. You can remove this for production.
if (file_put_contents("./callback-payment.json", json_encode($post)) === false)
    echo "error writing callback file";
else
    echo "written callback";
?>
