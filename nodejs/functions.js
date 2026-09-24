const crypto = require('crypto')

/**
 * Generate the signature to create a new payment.
 * This is only needed if "Enforce API Signatures" is enabled in your account.
 * @param params
 * @param secretToken
 * @returns {string}
 */
function generatePromptCashSignature(params, secretToken) {
    const input = secretToken + params.token + params.tx_id + params.amount +
        params.currency + params.desc + params.callback + params.return + params.time;
    return crypto.createHash('sha256').update(input, 'utf8').digest('hex');
}

/**
 * Check if a payment callback really comes from Prompt.Cash (prevents spoofing).
 * Prompt.Cash signs the raw request body with your secret token and sends the result
 * in the "X-Signature" HTTP header: hex(HMAC-SHA256(key = secretToken, message = raw body)).
 * @param req the express request (req.rawBody must be set, see express.json() "verify" option)
 * @param secretToken
 * @returns {boolean}
 */
function isValidPromptCashCallback(req, secretToken) {
    if (!secretToken)
        return false;
    const signature = (req.get("X-Signature") || "").trim().toLowerCase();
    if (signature) {
        const expected = crypto.createHmac('sha256', secretToken).update(req.rawBody || "").digest('hex');
        return safeEqual(expected, signature);
    }

    // Deprecated: the "token" JSON key will be removed. Only kept for the transition period.
    return typeof req.body.token === "string" && safeEqual(secretToken, req.body.token);
}

function safeEqual(a, b) {
    const bufA = Buffer.from(a, 'utf8');
    const bufB = Buffer.from(b, 'utf8');
    return bufA.length === bufB.length && crypto.timingSafeEqual(bufA, bufB);
}

function getRandomString(len) {
    let chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
    let random = ''
    for (let i = 0; i < len; i++)
        random += chars.charAt(Math.floor(Math.random() * chars.length))
    return random
}

module.exports = {generatePromptCashSignature, isValidPromptCashCallback, getRandomString}
