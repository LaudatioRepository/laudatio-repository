/**
 * Created by rolfguescini on 05.07.17.
 */
axios = require('axios');
const util = require('util');

function getDocumentsByAnnotations(annotations){
    var documentCounts = [];
    //console.log("GOT annotationCollection: "+ util.inspect(annotations)+" AND: "+typeof  annotations+" AND "+annotations.length);


    for(var annotation in annotations){
        console.log("ANNOTAITON: "+annotation);
        var postdata = [];
        postdata['document_list_of_annotations_name'] = annotation;
        console.log("MADE POSTDATA: "+JSON.stringify(postdata))
        window.axios.post('api/searchapi/searchDocument',JSON.stringify(postData)).then(res => {
            if(res.data.results.length > 0) {
                documentCounts.push({ [annotation] : res.data.hits.total})
            }
        });

    }
    console.log("RETRUNING: "+JSON.stringify(documentCounts))
    return documentCounts;
}

module.exports = {
    getDocumentsByAnnotations: getDocumentsByAnnotations
};