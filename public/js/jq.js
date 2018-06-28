/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 152);
/******/ })
/************************************************************************/
/******/ ({

/***/ 152:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(153);


/***/ }),

/***/ 153:
/***/ (function(module, exports) {

/**
 * Created by rolfguescini on 28.03.18.
 */
/**
 * functionality to be done onb document load
 */
jQuery(window).on('load', function () {
    var path = window.location.pathname.substr(1);

    $.each($('a.nav-link.headerlink'), function () {
        if ($(this).hasClass(path)) {
            $(this).parent().addClass('active');
            return false;
        }
    });

    if (path.indexOf('published') > -1) {
        var patharray = path.split('/');
        var sortBy = patharray[2];

        var sortTitle = "";
        if (typeof sortBy != "undefined") {
            $("a[data-sort]").each(function () {
                $(this).removeClass('disabled');
                var sortType = $(this).data('sort');
                if (sortType == sortBy) {
                    sortTitle = $(this).html();
                    $(this).addClass('disabled');
                    return false;
                }
            });
            $('#searchSort').html(sortTitle);
        }
    }
});

$(function () {
    //switch between header upload views
    if (typeof laudatioApp != 'undefined') {
        if (laudatioApp.corpusUpload) {
            $('#corpusUploader').css('display', 'block');
        } else {
            $('#corpusFileList').css('display', 'block');
        }

        if (laudatioApp.documentUpload) {
            $('#documentUploader').css('display', 'block');
        } else {
            $('#documentFileList').css('display', 'block');
        }

        if (laudatioApp.annotationUpload) {
            $('#annotationUploader').css('display', 'block');
        } else {
            $('#annotationFileList').css('display', 'block');
        }
    }

    // Make sure Bootstrap tabs work correctly to show the correct active states
    if (window.location.hash) {
        var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character

        $.each($('div.nav-item.maintablink'), function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            }
        });
        $('#' + hash + "_nav").addClass('active');
        $.each($('div.tab-pane.mainpanel.active'), function () {

            $(this).removeClass('active');
            $(this).addClass('fade in');
        });
        $('#' + hash).removeClass('fade in');
        $('#' + hash).addClass('active');
    } else {}
    // Fragment doesn't exist


    /**
     * Hide error banner initially
     */
    $("#alert-laudatio").hide();

    /**
     * add the correct foldername to the basepath according to which header is active
     */

    if ($("nav.headernav").find("a[data-headertype ='corpus']").hasClass('active')) {
        if (typeof window.Laravel != 'undefined') {
            window.Laravel.directorypath += '/TEI-HEADERS/corpus';
        }
    }

    $('nav.headernav a[data-headertype ="corpus"]').bind('click', function (e) {
        if (typeof window.Laravel != 'undefined') {
            var oldPath = window.Laravel.directorypath.substr(0, window.Laravel.directorypath.indexOf('/TEI'));
            window.Laravel.directorypath = oldPath + '/TEI-HEADERS/corpus';

            var previews = $('#previews').detach();
            previews.html("");
            previews.appendTo($('#tabcontainer'));
        }
    });

    $('nav.headernav a[data-headertype ="document"]').bind('click', function (e) {
        if (typeof window.Laravel != 'undefined') {
            var oldPath = window.Laravel.directorypath.substr(0, window.Laravel.directorypath.indexOf('/TEI'));
            window.Laravel.directorypath = oldPath + '/TEI-HEADERS/document';

            var previews = $('#previews').detach();
            previews.html("");
            previews.appendTo($('#tabcontainer'));
        }
    });

    $('nav.headernav a[data-headertype ="annotation"]').bind('click', function (e) {
        if (typeof window.Laravel != 'undefined') {
            var oldPath = window.Laravel.directorypath.substr(0, window.Laravel.directorypath.indexOf('/TEI'));
            window.Laravel.directorypath = oldPath + '/TEI-HEADERS/annotation';

            var previews = $('#previews').detach();
            previews.html("");
            previews.appendTo($('#tabcontainer'));
        }
    });

    /**
     * Make sure that the bootstrap tabs handle active / unactive correctly
     */
    $(document).on('click', 'a.nav-link.maintablink', function (e) {
        $.each($('a.nav-link.maintablink'), function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).parent().addClass('active');
            }
        });
    });

    $(document).on('click', 'a.nav-link.maintablink', function (e) {
        $.each($('a.nav-item.maintablink'), function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).parent().addClass('active');
            }
        });
    });

    $(document).on('click', 'a.nav-link.stacktablink', function (e) {
        var thatself = $(this);
        $.each($('a.nav-link.stacktablink'), function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            }
        });
        $(thatself).addClass('active');
    });

    /**
     * switch between file list and upload view
     */
    $(document).on('click', '.uploadcontrols', function () {
        var headerTypeArray = $(this).attr('id').split('_');
        var headerType = headerTypeArray[0];
        var headerAction = headerTypeArray[1];
        if (headerAction.indexOf('Upload') > -1) {
            var previews = $('#previews').detach();
            previews.appendTo($('#' + headerType + 'UploadPreview'));
            $('#' + headerType + 'Uploader').css('display', 'block');
            $('#' + headerType + 'FileList').css('display', 'none');
        } else {
            $('#' + headerType + 'Uploader').css('display', 'none');
            var previews = $('#previews').detach();
            previews.html("");
            previews.appendTo($('#tabcontainer'));
            $('#' + headerType + 'FileList').css('display', 'block');
        }
    });

    /**
     * Submit the sign in form
     */
    $(document).on('submit', '#signInForm', function (e) {
        e.preventDefault();
        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json"
        }).done(function (data) {
            if (data.success) {
                var newUri = window.location.origin + data.redirect;
                history.pushState({}, null, newUri);
                location.reload();
            } else {
                $('#login-error-message').text(data.message);
                $('#login-error-message').css('display', 'block');
            }
        }).fail(function (data) {
            console.log("FAIL : " + data);
        });
    });

    /**
     * submit corpus project updates
     */
    $(document).on('submit', '.updateform', function (e) {
        e.preventDefault();
        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var requestdata = $(this).serialize();
        var inputs = requestdata.split("&");

        var postdata = {};
        var fielddata = {};
        for (var i = 0; i < inputs.length; i++) {
            var inputdata = inputs[i].split("=");
            var field = inputdata[0].substr(0, inputdata[0].lastIndexOf("_"));
            postdata[field] = decodeURIComponent(inputdata[1]);
            var projectid = inputdata[0].substr(inputdata[0].lastIndexOf("_") + 1);
            postdata['projectid'] = decodeURIComponent(projectid);
            if (field.indexOf("name") > -1) {
                fielddata['corpusProject-title_' + projectid] = decodeURIComponent(inputdata[1]);
            } else {
                fielddata['corpusProject-description_' + projectid] = decodeURIComponent(inputdata[1]);
            }
        }

        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: postdata,
            dataType: "json"
        }).done(function (data) {
            if (data.status == "success") {

                var message = '<ul>The project data was successfully updated</ul>';
                $('#alert-laudatio').addClass('alert-success');
                $('#alert-laudatio .alert-laudatio-message').html(message);
                $.each(fielddata, function (key, val) {
                    $('#' + key).html(val);
                });
                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                    $("#alert-laudatio").slideUp(500);
                });
            } else if (data.status == "error") {
                console.log(data);
                var message = '<ul>';
                if (typeof data.message.eloquent_response != 'undefined') {
                    message += '<li>' + data.message.eloquent_response + '</li>';
                }

                if (typeof data.message.gitlab_response != 'undefined') {
                    message += '<li>' + data.message.gitlab_response + '</li>';
                }
                message += '</ul>';

                $('#alert-laudatio').addClass('alert-danger');
                $('#alert-laudatio .alert-laudatio-message').html(message);

                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                    $("#alert-laudatio").slideUp(500);
                });
            }
        }).fail(function (data) {
            $('#alert-laudatio').addClass('alert-danger');
            $('#alert-laudatio .alert-laudatio-message').html("There was an unexpected error. A message has been sent to the site administrator. Please try again later");

            $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert-laudatio").slideUp(500);
            });
        });
    });

    /**
     * Get and show citation according to chosen format
     */

    $(document).on('click', '#citeButton', function (e) {
        var jsondata = window.laudatioApp.citedata;
        var postdata = {};
        postdata['data'] = jsondata;
        getCitationData(postdata).then(function (citeData) {
            $('#citations').val(JSON.stringify(citeData.message));
            $('#citation-text').html(citeData.message.apa);
            $('#citation-modal').modal('show');
        });
    });

    /**
     * Set correct citation text by format
     */
    $(document).on('click', '#citationtabs div div a', function (e) {
        var citationdata = JSON.parse($('#citations').val());
        $('#citation-text').html();
        var citation = citationdata[$(this).data('cite-format')].replace(new RegExp('\n', 'g'), '<br />');
        $('#citation-text').html(citation);
    });

    /**
     * Copy citation text to clipboard
     */
    $(document).on('click', '#clipboard-btn', function (e) {
        var citationtext = document.querySelector('#citation-text');

        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(citationtext);
        selection.removeAllRanges();
        selection.addRange(range);

        try {
            // Now that we've selected the anchor text, execute the copy command
            var successful = document.execCommand('copy', false, range);
            var msg = successful ? 'The citation was copied to the clipboard' : 'There was a problem copying the citation to the clipboard';
            $('#alert-laudatio').addClass('alert-success');
            $('#alert-laudatio .alert-laudatio-message').html(msg);
            $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                $("#alert-laudatio").slideUp(500);
            });
        } catch (err) {
            console.log('Oops, unable to copy');
        }

        // Remove the selections - NOTE: Should use
        // removeRange(range) when it is supported
        selection.removeAllRanges();
    });

    /**
     * Sort the the corpora
     */
    $(document).on('click', '#pageSort a', function (e) {
        var route = window.location;
        var sortby = $(this).data('sort');
        var perPage = $('#pageResultButton').find(":selected").val();
        window.location = route.origin + '/published/' + perPage + '/' + sortby;
    });

    /**
     * Update the perPage variable for published corpora
     */
    $(document).on('change', '#pageResultButton', function (e) {
        var route = window.location;
        var pageTotal = $('#pageTotal').val();
        var path = route.pathname.substr(1);
        var patharray = path.split('/');
        var sortBy = patharray[2];
        console.log(sortBy);
        var perPage = $(this).find(":selected").val();
        if (perPage == "all") {
            perPage = pageTotal;
        }
        if (typeof sortBy != 'undefined') {
            window.location = route.origin + '/published/' + perPage + '/' + sortBy;
        } else {
            window.location = route.origin + '/published/' + perPage + '/1';
        }
    });

    //********** BOARD MESSAGES *********//

    /**
     * Save Board Message
     */
    $(document).on('click', '#sendMessageButton', function (e) {
        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var postdata = {};
        postdata['project_id'] = $('#project_id').val();
        postdata['corpus_id'] = $('#corpus_id').val();
        postdata['message'] = $('#created_boardmessage').val();
        postdata['user_id'] = $('#user_id').val();
        console.log(postdata);
        $.ajax({
            method: 'POST',
            url: '/api/adminapi/postMessage',
            data: postdata,
            dataType: "json"
        }).done(function (data) {
            if (data.status == "success") {
                console.log(data.message.messageboard_response);
                $('#alert-laudatio').addClass('alert-success');
                $('#alert-laudatio .alert-laudatio-message').html(data.message.messageboard_response);
                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                    $("#alert-laudatio").slideUp(500);
                    location.reload();
                });
            } else if (data.status == "error") {
                console.log(data.message.messageboard_response);
                $('#alert-laudatio').addClass('alert-danger');
                $('#alert-laudatio .alert-laudatio-message').html(data.message.messageboard_response);

                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                    $("#alert-laudatio").slideUp(500);
                });
            }
        }).fail(function (data) {
            console.log("FAIL : " + data);
        });
    });

    /**
     * Assign message to user
     */
    $(document).on('click', '#messageAssignButton', function (e) {
        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var postdata = {};
        postdata['message_id'] = $(this).data('message-id');
        postdata['user_id'] = $(this).data('message-assign');
        console.log(postdata);
        $.ajax({
            method: 'POST',
            url: '/api/adminapi/assignMessage',
            data: postdata,
            dataType: "json"
        }).done(function (data) {
            if (data.status == "success") {
                console.log(data.message.message_assign_response);
                $('#alert-laudatio').addClass('alert-success');
                $('#alert-laudatio .alert-laudatio-message').html(data.message.message_assign_response);
                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                    $("#alert-laudatio").slideUp(500);
                    location.reload();
                });
            } else if (data.status == "error") {
                console.log(data.message.message_assign_response);
                $('#alert-laudatio').addClass('alert-danger');
                $('#alert-laudatio .alert-laudatio-message').html(data.message.message_assign_response);

                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                    $("#alert-laudatio").slideUp(500);
                });
            }
        }).fail(function (data) {
            console.log("FAIL : " + data);
        });
    });

    /**
     * Complete boardmessage
     */
    $(document).on('click', '#messageCompleteButton', function (e) {
        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var postdata = {};
        postdata['message_id'] = $(this).data('message-id');
        console.log(postdata);
        $.ajax({
            method: 'POST',
            url: '/api/adminapi/completeMessage',
            data: postdata,
            dataType: "json"
        }).done(function (data) {
            if (data.status == "success") {
                console.log(data.message.message_complete_response);
                $('#alert-laudatio').addClass('alert-success');
                $('#alert-laudatio .alert-laudatio-message').html(data.message.message_complete_response);
                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                    $("#alert-laudatio").slideUp(500);
                    location.reload();
                });
            } else if (data.status == "error") {
                console.log(data.message.message_complete_response);
                $('#alert-laudatio').addClass('alert-danger');
                $('#alert-laudatio .alert-laudatio-message').html(data.message.message_complete_response);

                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                    $("#alert-laudatio").slideUp(500);
                });
            }
        }).fail(function (data) {
            console.log("FAIL : " + data);
        });
    });

    /**
     * Delete board message
     */
    $(document).on('click', '#deleteMessageButton', function (e) {
        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var postdata = {};
        postdata['message_id'] = $(this).data('message-id');
        console.log(postdata);
        $.ajax({
            method: 'POST',
            url: '/api/adminapi/deleteMessage',
            data: postdata,
            dataType: "json"
        }).done(function (data) {
            if (data.status == "success") {
                console.log(data.message.message_delete_response);
                $('#alert-laudatio').addClass('alert-success');
                $('#alert-laudatio .alert-laudatio-message').html(data.message.message_delete_response);
                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                    $("#alert-laudatio").slideUp(500);
                    location.reload();
                });
            } else if (data.status == "error") {
                console.log(data.message.message_delete_response);
                $('#alert-laudatio').addClass('alert-danger');
                $('#alert-laudatio .alert-laudatio-message').html(data.message.message_delete_response);

                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function () {
                    $("#alert-laudatio").slideUp(500);
                });
            }
        }).fail(function (data) {
            console.log("FAIL : " + data);
        });
    });

    //********** PUBLICATION ***********//

    /**
     * Validate corpus for publication
     *
     */
    $(document).on('click', '#publishCorpusButton', function () {
        var postPublishData = {};
        postPublishData.corpusid = window.laudatioApp.corpus_id;
        postPublishData.corpuspath = window.laudatioApp.corpus_path;

        getPublishTestData(postPublishData).then(function (publishData) {

            //var json = JSON.parse(publishData.msg);
            var jsonData = publishData.msg;

            $('#publicationModalLabel').html(jsonData.title);
            $('#publicationModal').modal('show');
            var html = '<div id="preparationWrapper">';

            html += '<div id="subtitle">' + jsonData.subtitle + '</div>';
            html += '<div id="waiting">' + jsonData.waiting + '</div>';

            html += '<ul class="list-group">';

            html += '<li class="list-group-item">';
            html += '' + jsonData.corpus_header.title + '';
            if (jsonData.corpus_header.corpusHeaderText != '') {
                html += '<br /><span class="has-error>' + jsonData.corpus_header.corpusHeaderText + '</span>';
            }
            html += '<i class="material-icons pull-right">' + jsonData.corpus_header.corpusIcon + '</i>';
            html += '</li>';

            html += '<li class="list-group-item">';
            html += '' + jsonData.document_headers.title + '';
            if (jsonData.document_headers.documentHeaderText != '') {
                html += '<br /><span class="has-error">' + jsonData.document_headers.documentHeaderText + '</span>';
            }
            html += '<i class="material-icons pull-right">' + jsonData.document_headers.documentIcon + '</i>';
            html += '</li>';

            html += '<li class="list-group-item">';
            html += '' + jsonData.annotation_headers.title + '';
            if (jsonData.annotation_headers.annotationHeaderText != '') {
                html += '<br /><span class="has-error">' + jsonData.annotation_headers.annotationHeaderText + '</span>';
            }
            html += '<i class="material-icons pull-right">' + jsonData.annotation_headers.annotationIcon + '</i>';
            html += '</li>';

            html += '</ul>';

            html += '</div>';

            if (jsonData.canPublish == false) {
                $('#doPublish').attr("disabled", "disabled");
            }
            $('#publicationModal .modal-dialog .modal-content .modal-body').html(html);
        }).catch(function (err) {
            // Run this when promise was rejected via reject()
            console.log(err);
        });
    });

    /**
     * Validate Corpus For Publication
     */
    $(document).on('click', '#validateCorpusButton', function () {
        var postData = {};
        postData.corpusid = $('#corpusid').val();
        postData.corpuspath = $('#corpuspath').val();

        getValidationData(postData).then(function (data) {
            var json = JSON.parse(data.msg);

            var newModaltitle = "Validation results for corpus/" + json.corpusheader;
            $('#myModalLabelValidation').html(newModaltitle);
            $('#myValidatorModal').modal('show');

            var html = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

            html += '<div class="panel panel-default">';
            html += '<div class="panel-heading" role="tab" id="documentHeading">';
            html += '<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#documentsInCorpus" aria-expanded="false" aria-controls="documentsInCorpus">Documents in corpus</a></h4></div>';
            html += '<div id="documentsInCorpus" class="panel-collapse collapse" role="tabpanel" aria-labelledby="documentHeading"><div class="list-group">';
            html += '<ul class="list-group">';
            for (var i = 0; i < json.found_documents.length; i++) {
                html += '<li class="list-group-item">' + json.found_documents[i].title + ' <i class="material-icons pull-right">check_circle</i></li>';
            }

            var not_found_documents = json.not_found_documents_in_corpus.sort();

            for (var j = 0; j < not_found_documents.length; j++) {
                html += '<li class="list-group-item">' + not_found_documents[j] + ' <i class="material-icons pull-right">warning</i></li>';
            }
            html += '</ul>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="panel panel-default">';
            html += '<div class="panel-heading" role="tab" id="annotationHeading">';
            html += '<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#annotationsInCorpus" aria-expanded="false" aria-controls="annotationsInCorpus">Annotations in corpus</a></h4></div>';
            html += '<div id="annotationsInCorpus" class="panel-collapse collapse" role="tabpanel" aria-labelledby="annotationHeading"><div class="list-group">';

            html += '<ul class="list-group">';

            for (var k = 0; k < json.found_annotations_in_corpus.length; k++) {
                html += '<li class="list-group-item">' + json.found_annotations_in_corpus[k] + ' <i class="material-icons pull-right">check_circle</i></li>';
            }

            var not_found_annotations = json.not_found_annotations_in_corpus.sort();
            for (var l = 0; l < not_found_annotations.length; l++) {
                html += '<li class="list-group-item">' + not_found_annotations[l] + ' <i class="material-icons pull-right">warning</i></li>';
            }

            html += '</ul>';

            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '</div>';
            $('.modal-body').html(html);
        }).catch(function (err) {
            // Run this when promise was rejected via reject()
            console.log(err);
        });
    });
});

/** FUNCTIONS **/

/**
 * Validate headers promise
 * @param postData
 * @returns {Promise}
 */
function getValidationData(postData) {
    return new Promise(function (resolve, reject) {

        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/api/adminapi/validateHeaders',
            type: "POST",
            data: postData,
            async: true,
            statusCode: {
                500: function _() {
                    alert("server down");
                }
            },
            success: function success(data) {
                resolve(data); // Resolve promise and go to then()
            },
            error: function error(err) {
                reject(err); // Reject the promise and go to catch()
            }
        });
    });
}

/**
 * preparepublication promise
 * @param postData
 * @returns {Promise}
 */
function getPublishTestData(postData) {
    return new Promise(function (resolve, reject) {

        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/api/adminapi/preparePublication',
            type: "POST",
            data: postData,
            async: true,
            statusCode: {
                500: function _() {
                    alert("server down");
                }
            },
            success: function success(data) {
                resolve(data); // Resolve promise and go to then()
            },
            error: function error(err) {
                reject(err); // Reject the promise and go to catch()
            }
        });
    });
}

/**
 * get Citation Data promise
 * @param postData
 * @returns {Promise}
 */
function getCitationData(postData) {
    return new Promise(function (resolve, reject) {

        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/download/citation',
            type: "POST",
            data: postData,
            async: true,
            statusCode: {
                500: function _() {
                    alert("server down");
                }
            },
            success: function success(data) {
                resolve(data); // Resolve promise and go to then()
            },
            error: function error(err) {
                reject(err); // Reject the promise and go to catch()
            }
        });
    });
}

/***/ })

/******/ });