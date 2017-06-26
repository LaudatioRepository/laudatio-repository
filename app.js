/**
 * Created by rolfguescini on 23.06.17.
 */
var express = require('express');
var app = express();
var path = require('path');
var server = require('http').createServer(app);
var axios = require('axios');
var querystring = require('querystring');

port = process.env.PORT || 4000;

require('dotenv').config();

var bodyParser = require('body-parser');
app.use( bodyParser.json() );

var routes = require('./routes');
routes(app);

if (process.env.NODE_ENV !== 'production') {
    require('reload')(server, app);
}

server.listen(port, function () {
    console.log('Listening on port '.concat(port))
});
