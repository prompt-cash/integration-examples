import * as express from "express";
const app = express()
const port = 3000
app.set('view engine', 'pug')
app.use(express.json()); // middleware to parse the JSON callback
const functions = require('./functions')

// values from your account: https://prompt.cash/account
const publicToken = "29-Cg2K8RSB";
const secretToken = "29-FOYcmJZTnbHFPdCxfdbGw8qofnMf4R6CKp0hA9yhBUnKrluygwPuMOUyRPYspR9m";
app.use()

app.get('/some-path', (req, res, next) => {

});
