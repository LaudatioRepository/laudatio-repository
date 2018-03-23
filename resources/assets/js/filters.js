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
    if(string == "NA"){
        string = "-";
    }
    return string;
});

Vue.filter('touppercase', function (string){
    if(typeof string != 'undefined') {
        return string.toUpperCase();
    }
});


Vue.filter('addHash', function (string) {
    return "#".concat(string);
});

Vue.filter('lastElement', function (collection) {
    return collection[collection.length-1];
});

Vue.filter('formatSize', function (size) {
    if (size > 1024 * 1024 * 1024 * 1024) {
        return (size / 1024 / 1024 / 1024 / 1024).toFixed(2) + ' TB'
    } else if (size > 1024 * 1024 * 1024) {
        return (size / 1024 / 1024 / 1024).toFixed(2) + ' GB'
    } else if (size > 1024 * 1024) {
        return (size / 1024 / 1024).toFixed(2) + ' MB'
    } else if (size > 1024) {
        return (size / 1024).toFixed(2) + ' KB'
    }
    return size.toString() + ' B'
})

Vue.filter('toLocale', function (to) {
    return '/' + i18n.locale + to
})