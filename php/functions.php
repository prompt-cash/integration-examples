<?php

/**
 * Generate the signature to create a new payment.
 * This is only needed if "Enforce API Signatures" is enabled in your account.
 * @param array $params
 * @param string $secretToken
 * @return string
 */
function generatePromptCashSignature(array $params, string $secretToken): string {
    return hash('sha256', $secretToken . $params['token'] . $params['id'] . $params['amount'] .
        $params['currency'] . $params['desc'] . $params['callback'] . $params['return'] . $params['time']);
}

function getRandomString(int $len): string {
    $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $max = strlen($chars)-1;
    mt_srand();
    $random = '';
    for ($i = 0; $i < $len; $i++)
        $random .= $chars[mt_rand(0, $max)];
    return $random;
}
?>