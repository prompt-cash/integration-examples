const crypto = require('crypto')

/**
 * Generate the signature to create a new payment.
 * This is only needed if "Enforce API Signatures" is enabled in your account.
 * @param params
 * @param secretToken
 * @returns {string}
 */
function generatePromptCashSignature(params, secretToken) {
    const input = secretToken + params.token + params.id + params.amount +
        params.currency + params.desc + params.callback + params.return + params.time;
    return crypto.createHash('sha256').update(input, 'utf8').digest('hex');
}

function getRandomString(len) {
    let chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
    let random = ''
    for (let i = 0; i < len; i++)
        random += chars.charAt(Math.floor(Math.random() * chars.length))
    return random
}

module.exports = {generatePromptCashSignature, getRandomString}
