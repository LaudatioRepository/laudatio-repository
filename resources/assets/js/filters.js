/**
 * Created by rolfguescini on 28.06.17.
 */
Vue = require('vue');

Vue.filter('arrayToString', function (array) {
    var string = '';
    if(array.isArray && array.length == 1) {
        string = array[0].toString();
    }
    else{
        string = array.toString();
    }
    return string;
});