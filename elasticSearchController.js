/**
 * Created by rolfguescini on 26.06.17.
 */
var client = require('./connect.js');
var builder = require('elastic-builder');

const util = require('util')


/** GET **/

exports.getHealth = function (req,res) {
    console.log("client: "+util.inspect(req));
    client.cluster.health({},function(err,resp,status) {
        if (err){
            console.error(err);
            res.statusCode = 500;
            return res.json({ errors: "Cold not fetch Health info" });
        }
        console.log("-- Client Health --",resp);
        res.status(200).send(resp);

    });
}

exports.getInfo = function (req,res){
    client.info({},function(err,resp, status){
        if (err){
            console.error(err);
            res.statusCode = 500;
            return res.json({ errors: "Cold not fetch Server info" });
        }
        res.status(200).send(resp);
    });
}


exports.getIndices = function (req,res){
    client.indices.get({'index': "_all"},function(err,resp, status){
        if (err){
            console.error(err);
            res.statusCode = 500;
            return res.json({ errors: "Cold not fetch Indices" });
        }
        res.status(200).send(resp);
    });
}

exports.searchIndexMatchAll = function (req,res){
    var requestBody = new builder.requestBodySearch()
        .query(builder.matchAllQuery());
    console.log(builder.prettyPrint(requestBody)+ "FOR: "+req.params.index_name);
    client.search({
        index: req.params.index_name,
        body: builder.prettyPrint(requestBody)
    },function(err,resp, status){
        if (err){
            console.error(err);
            res.statusCode = 500;
            return res.json({ errors: "Cold not do search: matchAll" });
        }
        res.status(200).send(resp);
    });
}


exports.searchIndex = function (req,res){
    var query = new builder.requestBodySearch()
        .query(builder.matchQuery(
            req.body.field,
            req.body.queryString
        )).
        source({
            'excludes': [ 'message' ]
        });
    console.log(builder.prettyPrint(query)  + "FOR: "+req.body.index_name);
    client.search({
        index: req.body.index_name,
        body: query
    },function(err,resp, status){
        if (err){
            console.error(err);
            res.statusCode = 500;
            return res.json({ errors: "Cold not do search: matchAll" });
        }
        res.status(200).send(resp);
    });
}




/** POST **/

exports.createIndex = function (req,res) {
    console.log("FOR: "+req.body.index_name);
    client.indices.create({
        index: req.body.index_name
    },function(err,resp,status) {
        if(err) {
            console.log(err);
        }
        else {
            console.log("Created  index "+req.body.index_name);
        }
        res.status(201).send(resp);
    });
}


/** DELETE **/
exports.deleteIndex = function (req,res) {
    client.indices.delete({
        index: req.body.index_name
    },function(err,resp,status) {
        if(err) {
            console.log(err);
        }
        else {
            console.log("Deleted  index "+req.body.index_name);
        }
        res.status(201).send(resp);
    });
}