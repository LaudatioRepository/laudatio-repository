/**
 * Created by rolfguescini on 28.06.17.
 */
Vue = require('vue');

Vue.filter('arrayToString', function (array) {
    var string = '';
    if(array)
    if(array.isArray && array.length == 1) {
        string = array[0].toString();
    }
    else{
        string = array.toString();
    }
    return string;
});


Vue.filter('addHash', function (string) {
    return "#".concat(string);
});

Vue.filter('lastElement', function (collection) {
    return collection[collection.length-1];
});