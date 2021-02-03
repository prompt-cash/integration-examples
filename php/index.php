<?php
require_once 'config.php';
require_once 'functions.php';

$params = array(
    'token' => $publicToken,
    'id' => getRandomString(12), // put your Order ID or other unique ID here (MySQL primary key or MongoDB _id)
    'amount' => sprintf("%.2f", 0.01), // make sure to use string with fixed decimals to avoid floating point inconsistency
    'currency' => 'USD',
    'desc' => 'PHP Demo',

    // the URL to send the customer back to after payment
    'return' => 'http://your-domain.com/index.php?paid=1',

    // Where to notify you of changes in the payment status (expired or paid).
    // This must be on a public domain. The callback will not work when you are testing on localhost!
    'callback' => 'http://your-domain.com/callback.php',

    'time' => time(),
    'signature' => '',
);
$params['signature'] = generatePromptCashSignature($params, $secretToken);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            margin: 5px 5px 5px 5px;
        }
    </style>
    <title>Prompt.Cash PHP Demo</title>
</head>
<body>
<h1>Prompt.Cash PHP Demo</h1>

<?php if (isset($_GET['paid'])): ?>
    <p>Thanks for your payment. We will email you when your order gets shipped.</p>
<?php else: ?>
    <!--this is the form you can copy and paste from our website: https://prompt.cash/integration -->
    <form name="prompt-cash-form" action="http://danielmac.local:2929/pay" method="get">
        <?php foreach ($params as $name => $value): ?>
            <input type="hidden" name="<?php echo $name;?>" value="<?php echo $value;?>">
        <?php endforeach; ?>
        <button type="submit" class="btn btn-success">Pay with BitcoinCash (BCH)</button>
    </form>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
