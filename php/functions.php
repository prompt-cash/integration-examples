<?php

/**
 * Generate the signature to create a new payment.
 * This is only needed if "Enforce API Signatures" is enabled in your account.
 * @param array $params
 * @param string $secretToken
 * @return string
 */
function generatePromptCashSignature(array $params, string $secretToken): string {
    return hash('sha256', $secretToken . $params['token'] . $params['tx_id'] . $params['amount'] .
        $params['currency'] . $params['desc'] . $params['callback'] . $params['return'] . $params['time']);
}

/**
 * Check if a payment callback really comes from Prompt.Cash (prevents spoofing).
 * Prompt.Cash signs the raw request body with your secret token and sends the result
 * in the "X-Signature" HTTP header: hex(HMAC-SHA256(key = secretToken, message = raw body)).
 * @param string $rawBody the unmodified request body from php://input
 * @param array $post the decoded JSON body
 * @param string $secretToken
 * @return bool
 */
function isValidPromptCashCallback(string $rawBody, array $post, string $secretToken): bool {
    if (empty($secretToken))
        return false;
    $signature = isset($_SERVER['HTTP_X_SIGNATURE']) ? strtolower(trim($_SERVER['HTTP_X_SIGNATURE'])) : '';
    if (!empty($signature))
        return hash_equals(hash_hmac('sha256', $rawBody, $secretToken), $signature);

    // Deprecated: the "token" JSON key will be removed. Only kept for the transition period.
    return isset($post['token']) && is_string($post['token']) && hash_equals($secretToken, $post['token']);
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
