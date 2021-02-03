const express = require('express')
const app = express()
const port = 3000
app.set('view engine', 'pug')
app.use(express.json()); // middleware to parse the JSON callback
const functions = require('./functions')

// values from your account: https://prompt.cash/account
const publicToken = "";
const secretToken = "";

// render the index page
app.get('/', (req, res) => {
    const params = {
        token: publicToken,
        id: functions.getRandomString(12), // put your Order ID or other unique ID here (MySQL primary key or MongoDB _id)
        amount: "0.01", // make sure to use string with fixed decimals to avoid floating point inconsistency
        currency: "USD",
        desc: "Node.Js Demo",

        // the URL to send the customer back to after payment
        return: "http://localhost:3000/?paid=1",

        // Where to notify you of changes in the payment status (expired or paid).
        // This must be on a public domain. The callback will not work when you are testing on localhost!
        callback: "http://localhost:3000/api/v1/callback",

        time: Math.floor(Date.now() / 1000),
        signature: ""
    }
    params.signature = functions.generatePromptCashSignature(params, secretToken);
    res.render('index', {
        params: params,
        paid: req.query["paid"] === "1"
    })
})

// process the payment callback we receive from Prompt.Cash
app.post('/api/v1/callback', (req, res) => {
    // The content type to respond is ignored by Prompt.Cash but you should return HTTP Status Code 200
    res.contentType("text/plain; charset=UTF-8'");
    res.send("ok"); // any response is fine (ignored by Prompt.Cash)

    console.log("Received callback", req.body)

    // check if the payment is complete
    if (req.body.token === secretToken) { // prevent spoofing
        if (req.body.payment.status === "PAID") {
            // Payment complete. Update your database and ship your order.
        }
        else if (req.body.payment.status === "EXPIRED") {
            // The customer did not pay in time. You can cancel this order or send him a new payment link.
        }
    }
})

app.listen(port, () => {
    console.log(`Example shop listening at http://localhost:${port}`)
})
