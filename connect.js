/**
 * Created by rolfguescini on 26.06.17.
 */
var elasticsearch=require('elasticsearch');
var config = require('config');


var elasticHosts = config.get('hosts');
var client = new elasticsearch.Client( {
    hosts: elasticHosts
});

module.exports = client;