# Promt.cash integration examples
This repository contains code examples of how to integrate [Prompt.cash](https://prompt.cash) 
as a payment processor in your backend.

See our [API reference](https://prompt.cash/pub/docs/) for detailed descriptions
of each parameter used in the following examples.

Also watch our [merchant introduction video](https://www.youtube.com/watch?v=8TIpZW1P_9M).

## static page
This is the most minimalistic integration example into a [static HTML page](static).
It will generate a new address for every payment. You can then view a payment history including
"payment description/reference" and used addresses in your account.

#### Installation
Just put the 2 HTML files on your webserver and customize the `input` values
in the `form` tag.


## Node.js
See the [nodejs](nodejs) folder.

This example can add server-side parameters (such as order ID) and 
add a signature to each payment to prevent spoofing.

#### Installation
In the `index.js` file, add the following:
- your Account `PublicToken` and `SecretToken`
- customize payment amount, currency and other parameters as needed
```
yarn install # npm works too
yarn start
```


## PHP
See the [php](php) folder.

This example can add server-side parameters (such as order ID) and
add a signature to each payment to prevent spoofing.

#### Installation
In the `config.php` file, add the following:
- your Account `PublicToken` and `SecretToken`

In the `index.php` file, add the following:  
- customize payment amount, currency and other parameters as needed


## WordPress
Just download our [WordPress plugin](https://wordpress.org/plugins/prompt-cash-monetize-your-blog-with-bitcoin-cash/).

You can install it directly within WordPress under Plugins -> Add New


## Android
We have an [Anrdoi App Demo](https://github.com/prompt-cash/androidDemo)
that shows you how to:
- display a QR code
- check for payment status

You can use this app as a template to accept Point of Sale (POS) payments.


## Payment Control flow
``` text 
     +-------------+                      +-------------+                      +-------------+
     |             |                      |   Merchant  |                      | Prompt.Cash |
     |   Customer  |                      |   Website   |                      | Payment     |
     |             |                      |             |                      | Gateway     |
     +-------------+                      +-------------+                      +-------------+
            |                                     |                                   |
            |--(1)--Payment Request-------------->|                                   |
            |                                     |                                   |
            |<--(2)--Generate Payment Form--------|                                   |
            |                                     |                                   |
            |---(3)--Click "Pay" & Go to Gateway------------------------------------->|
            |                                     |                                   |
            |                                     |<---(4)--Payment Success Callback--|
            |                                     |                                   |
            |<---------------------------------(5)--Send Customer back to Return URL--|
            |                                     |                                   |
            |                                     |                                   |
```


## Contact
[Website](https://prompt.cash/) -
[Twitter](https://twitter.com/CashPrompt) -
[Telegram](https://t.me/PromptCash) -
[YouTube](https://www.youtube.com/channel/UClfNVdL3T0RF6pF1yGi9teg)
