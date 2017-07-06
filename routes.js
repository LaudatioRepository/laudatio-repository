/**
 * Created by rolfguescini on 26.06.17.
 */
module.exports = function(app) {
    var elasticAPI = require('./elasticSearchController');

    app.route('/health')
        .get(elasticAPI.getHealth);

    app.route('/info')
        .get(elasticAPI.getInfo);

    app.route('/indices')
        .get(elasticAPI.getIndices)
        .post(elasticAPI.createIndex)
        .delete(elasticAPI.deleteIndex);

    app.route('/search_match_all/:index_name')
        .get(elasticAPI.searchIndexMatchAll);

    app.route('/search')
        .post(elasticAPI.searchIndex);

};