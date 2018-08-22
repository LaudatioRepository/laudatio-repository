/**
 * Created by rolfguescini on 28.03.18.
 */
/**
 * functionality to be done onb document load
 */
jQuery(window).on('load', function() {
    var path = window.location.pathname.substr(1);

    $.each($('a.nav-link.headerlink'),function(){
        if($(this).hasClass(path)){
            $(this).parent().addClass('active');
            return false;
        }
    });

    if(path.indexOf('published') > -1) {
        var patharray = path.split('/');
        var sortBy = patharray[2];

        var sortTitle = "";
        if(typeof sortBy != "undefined"){
            $("a[data-sort]").each(function(){
                $(this).removeClass('disabled')
                var sortType = $(this).data('sort');
                if(sortType == sortBy) {
                    sortTitle = $(this).html()
                    $(this).addClass('disabled')
                    return false;
                }
            });
            $('#searchSort').html(sortTitle);
        }

    }

});

$(function(){
    //switch between header upload views
    if(typeof laudatioApp != 'undefined'){
        if(laudatioApp.corpusUpload){
            $('#corpusUploader').css('display','block');
        }
        else {
            $('#corpusFileList').css('display','block');
        }

        if(laudatioApp.documentUpload){
            $('#documentUploader').css('display','block');
        }
        else {
            $('#documentFileList').css('display','block');
        }

        if(laudatioApp.annotationUpload){
            $('#annotationUploader').css('display','block');
        }
        else {
            $('#annotationFileList').css('display','block');
        }
    }

    // Make sure Bootstrap tabs work correctly to show the correct active states
    if(window.location.hash) {
        var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character

        $.each($('div.nav-item.maintablink'),function(){
            if($(this).hasClass('active')){
                $(this).removeClass('active');
            }
        });
        $('#'+hash+"_nav").addClass('active')
        $.each($('div.tab-pane.mainpanel.active'),function(){

                $(this).removeClass('active');
                $(this).addClass('fade in');

        });
        $('#'+hash).removeClass('fade in');
        $('#'+hash).addClass('active');
    } else {
        // Fragment doesn't exist
    }


    $('.helpLink').each(function(index, helpLinkElem) {
        var helpId = $(helpLinkElem).attr('id');
        var popupId = helpId ? 'help_' + helpId : undefined;
        if (popupId) {
            var popupElem = $('#'+popupId);
            var popupTitleHtml = $('.hd', popupElem).html();
            var popupBodyHtml = $('.bd', popupElem).html();
            $(helpLinkElem).popover({
                placement: 'auto top',
                viewport: '#deed',
                trigger: 'focus',
                title: popupTitleHtml ? popupTitleHtml : undefined,
                content: popupBodyHtml ? popupBodyHtml : undefined,
                html: true
            });
        }
    });

    $('.helpLink').on('click', function(e) {
        e.preventDefault();
    });


    /**
     * Hide error banner initially
     */
    $("#alert-laudatio").hide();

    /**
     * add the correct foldername to the basepath according to which header is active
     */

    if($("nav.headernav").find("a[data-headertype ='corpus']").hasClass('active')){
        if(typeof window.Laravel != 'undefined') {
            window.Laravel.directorypath += '/TEI-HEADERS/corpus';
        }
    }


    $('nav.headernav a[data-headertype ="corpus"]').bind('click', function (e) {
        if(typeof window.Laravel != 'undefined') {
            var oldPath = window.Laravel.directorypath.substr(0, window.Laravel.directorypath.indexOf('/TEI'))
            window.Laravel.directorypath = oldPath + '/TEI-HEADERS/corpus';

            var previews = $('#previews').detach();
            previews.html("");
            previews.appendTo($('#tabcontainer'));
        }
    });

    $('nav.headernav a[data-headertype ="document"]').bind('click', function (e) {
        if(typeof window.Laravel != 'undefined') {
            var oldPath = window.Laravel.directorypath.substr(0, window.Laravel.directorypath.indexOf('/TEI'))
            window.Laravel.directorypath = oldPath + '/TEI-HEADERS/document';

            var previews = $('#previews').detach();
            previews.html("");
            previews.appendTo($('#tabcontainer'));
        }
    });

    $('nav.headernav a[data-headertype ="annotation"]').bind('click', function (e) {
        if(typeof window.Laravel != 'undefined') {
            var oldPath = window.Laravel.directorypath.substr(0, window.Laravel.directorypath.indexOf('/TEI'))
            window.Laravel.directorypath = oldPath + '/TEI-HEADERS/annotation';

            var previews = $('#previews').detach();
            previews.html("");
            previews.appendTo($('#tabcontainer'));
        }
    });


    /**
     * Make sure that the bootstrap tabs handle active / unactive correctly
     */
    $(document).on('click','a.nav-link.maintablink',function(e){
        $.each($('a.nav-link.maintablink'),function(){
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).parent().addClass('active')
            }
        });
    });

    $(document).on('click','a.nav-link.maintablink',function(e){
        $.each($('a.nav-item.maintablink'),function(){
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).parent().addClass('active')
            }

        });
    });

    $(document).on('click','a.nav-link.stacktablink',function(e){
        var thatself = $(this);
        $.each($('a.nav-link.stacktablink'),function(){
            if($(this).hasClass('active')){
                $(this).removeClass('active');
            }
        });
        $(thatself).addClass('active');
    });


    /**
     * switch between file list and upload view
     */
    $(document).on('click','.uploadcontrols',function(){
        var headerTypeArray = $(this).attr('id').split('_');
        var headerType = headerTypeArray[0];
        var headerAction = headerTypeArray[1];
        if(headerAction.indexOf('Upload') > -1) {
            var previews = $('#previews').detach();
            previews.appendTo($('#'+headerType+'UploadPreview'));
            $('#'+headerType+'Uploader').css('display','block');
            $('#'+headerType+'FileList').css('display','none');
        }
        else{
            $('#'+headerType+'Uploader').css('display','none');
            var previews = $('#previews').detach();
            previews.html("");
            previews.appendTo($('#tabcontainer'));
            $('#'+headerType+'FileList').css('display','block');
        }


    });


    /**
     * select form check boxes
     */

    $("#selectAll_corpusEdit").click(function (e) {
        $(this).closest("table").find("td input:checkbox").prop("checked", this.checked);
    });

    $("#selectAll_documentEdit").click(function (e) {
        $(this).closest("table").find("td input:checkbox").prop("checked", this.checked);
    });

    $("#selectAll_annotationEdit").click(function (e) {
        $(this).closest("table").find("td input:checkbox").prop("checked", this.checked);
    });


    /**
     * Submit the sign in form
     */
    $(document).on('submit', '#signInForm', function(e) {
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
        })
            .done(function(data) {
                if(data.success){
                    var newUri = window.location.origin+data.redirect
                    history.pushState({}, null, newUri);
                    location.reload();
                }
                else{
                    $('#login-error-message').text(data.message)
                    $('#login-error-message').css('display','block');
                }
            })
            .fail(function(data) {
                console.log("FAIL : "+data)
            });
    });


    /**
     * submit corpus project updates
     */
    $(document).on('submit', '.updateform', function(e) {
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
        for(var i=0; i < inputs.length; i++) {
            var inputdata = inputs[i].split("=");
            var field = inputdata[0].substr(0,inputdata[0].lastIndexOf("_"));
            postdata[field] = decodeURIComponent(inputdata[1]);
            var projectid = inputdata[0].substr(inputdata[0].lastIndexOf("_")+1);
            postdata['projectid'] = decodeURIComponent(projectid)
            if(field.indexOf("name") > -1) {
                fielddata['corpusProject-title_'+projectid] = decodeURIComponent(inputdata[1])
            }
            else{
                fielddata['corpusProject-description_'+projectid] = decodeURIComponent(inputdata[1])
            }

        }

        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data: postdata,
            dataType: "json"
        })
            .done(function(data) {
                if(data.status == "success"){

                    var message = '<ul>The project data was successfully updated</ul>';
                    $('#alert-laudatio').addClass('alert-success');
                    $('#alert-laudatio .alert-laudatio-message').html(message)
                    $.each(fielddata,function (key,val) {
                        $('#'+key).html(val);
                    });
                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                    });
                }
                else if (data.status == "error"){
                    console.log(data)
                    var message = '<ul>';
                    if(typeof data.message.eloquent_response != 'undefined') {
                        message += '<li>'+data.message.eloquent_response+'</li>';
                    }

                    if(typeof data.message.gitlab_response != 'undefined') {
                        message += '<li>'+data.message.gitlab_response+'</li>';
                    }
                    message += '</ul>';

                    $('#alert-laudatio').addClass('alert-danger');
                    $('#alert-laudatio .alert-laudatio-message').html(message)

                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                    });
                }
            })
            .fail(function(data) {
                $('#alert-laudatio').addClass('alert-danger');
                $('#alert-laudatio .alert-laudatio-message').html("There was an unexpected error. A message has been sent to the site administrator. Please try again later")

                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert-laudatio").slideUp(500);
                });
            });
    });

    /**
     * Get and show citation according to chosen format
     */

    $(document).on('click', '#citeButton', function(e) {
        var jsondata = window.laudatioApp.citedata;
        var postdata = {}
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
    $(document).on('click', '#citationtabs div div a', function(e) {
        var citationdata = JSON.parse($('#citations').val());
        $('#citation-text').html();
        var citation = citationdata[$(this).data('cite-format')].replace(new RegExp('\n','g'), '<br />')
        $('#citation-text').html(citation);
    });

    /**
     * Copy citation text to clipboard
     */
    $(document).on('click', '#clipboard-btn', function(e) {
        var citationtext = document.querySelector('#citation-text');

        const selection = window.getSelection();
        const range = document.createRange();
        range.selectNodeContents(citationtext);
        selection.removeAllRanges();
        selection.addRange(range);

        try {
            // Now that we've selected the anchor text, execute the copy command
            var successful = document.execCommand('copy', false, range);
            var msg = successful ? 'The citation was copied to the clipboard' : 'There was a problem copying the citation to the clipboard';
            $('#alert-laudatio').addClass('alert-success');
            $('#alert-laudatio .alert-laudatio-message').html(msg)
            $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert-laudatio").slideUp(500);
            });
        } catch(err) {
            console.log('Oops, unable to copy');
        }

        // Remove the selections - NOTE: Should use
        // removeRange(range) when it is supported
        selection.removeAllRanges();
    });


    /**
     * Sort the the corpora
     */
    $(document).on('click', '#pageSort a', function(e) {
        var route = window.location
        var sortby = $(this).data('sort')
        var perPage = $('#pageResultButton').find(":selected").val();
        window.location = route.origin+'/published/'+perPage+'/'+sortby;
    });



    /**
     * Update the perPage variable for published corpora
     */
    $(document).on('change', '#pageResultButton', function(e) {
        var route = window.location
        var pageTotal =  $('#pageTotal').val();
        var path = route.pathname.substr(1);
        var patharray = path.split('/');
        var sortBy = patharray[2];

        var perPage = $(this).find(":selected").val();
        if(perPage == "all") {
            perPage = pageTotal;
        }
        if(typeof sortBy != 'undefined'){
            window.location = route.origin+'/published/'+perPage+'/'+sortBy;
        }
        else {
            window.location = route.origin+'/published/'+perPage+'/1';
        }

    });




    //********** BOARD MESSAGES *********//

    /**
     * Save Board Message
     */
    $(document).on('click', '#sendMessageButton', function(e) {
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
        })
            .done(function(data) {
                if(data.status == "success"){
                    console.log(data.message.messageboard_response)
                    $('#alert-laudatio').addClass('alert-success');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.messageboard_response)
                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                        location.reload()
                    });
                }
                else if (data.status == "error"){
                    console.log(data.message.messageboard_response)
                    $('#alert-laudatio').addClass('alert-danger');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.messageboard_response)

                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                    });
                }
            })
            .fail(function(data) {
                console.log("FAIL : "+data)
            });
    });

    /**
     * Assign message to user
     */
    $(document).on('click', '#messageAssignButton', function(e) {
        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var postdata = {};
        postdata['message_id'] = $(this).data('message-id');
        postdata['user_id'] =  $(this).data('message-assign');
        console.log(postdata);
        $.ajax({
            method: 'POST',
            url: '/api/adminapi/assignMessage',
            data: postdata,
            dataType: "json"
        })
            .done(function(data) {
                if(data.status == "success"){
                    console.log(data.message.message_assign_response)
                    $('#alert-laudatio').addClass('alert-success');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.message_assign_response)
                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                        location.reload()
                    });
                }
                else if (data.status == "error"){
                    console.log(data.message.message_assign_response)
                    $('#alert-laudatio').addClass('alert-danger');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.message_assign_response)

                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                    });
                }
            })
            .fail(function(data) {
                console.log("FAIL : "+data)
            });
    });

    /**
     * Complete boardmessage
     */
    $(document).on('click', '#messageCompleteButton', function(e) {
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
        })
            .done(function(data) {
                if(data.status == "success"){
                    console.log(data.message.message_complete_response)
                    $('#alert-laudatio').addClass('alert-success');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.message_complete_response)
                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                        location.reload()
                    });
                }
                else if (data.status == "error"){
                    console.log(data.message.message_complete_response)
                    $('#alert-laudatio').addClass('alert-danger');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.message_complete_response)

                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                    });
                }
            })
            .fail(function(data) {
                console.log("FAIL : "+data)
            });
    });

    /**
     * Delete board message
     */
    $(document).on('click', '#deleteMessageButton', function(e) {
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
        })
            .done(function(data) {
                if(data.status == "success"){
                    console.log(data.message.message_delete_response)
                    $('#alert-laudatio').addClass('alert-success');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.message_delete_response)
                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                        location.reload()
                    });
                }
                else if (data.status == "error"){
                    console.log(data.message.message_delete_response)
                    $('#alert-laudatio').addClass('alert-danger');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.message_delete_response)

                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                    });
                }
            })
            .fail(function(data) {
                console.log("FAIL : "+data)
            });
    });


    //********** PUBLICATION ***********//

    /**
     * Validate corpus for publication
     *
     */
    $(document).on('click', '#publishCorpusButton',function (){
        var postPublishData = {}


        if(typeof window.laudatioApp != 'undefined') {
            postPublishData.corpusid = window.laudatioApp.corpus_id;
            postPublishData.corpuspath = window.laudatioApp.corpus_path;
        }
        else {
            postPublishData.corpusid = $(this).data('corpusid');
            postPublishData.corpuspath = $(this).data('corpuspath');
        }

        getPublishTestData(postPublishData).then(function(publishData){

            //var json = JSON.parse(publishData.msg);
            var jsonData = publishData.msg

            $('#publishCorpusModalTitle').html(jsonData.title);
            $('#publishCorpusModalSubtitle').html(jsonData.subtitle);

            var html = '<div id="preparationWrapper">';

            html += '<ul class="list-group">';

            html += '<li class="list-group-item d-flex justify-content-between align-items-center">';

            if(jsonData.corpus_header.corpusHeaderText != ''){
                html += '<br /><small class="text-primary">'+jsonData.corpus_header.corpusHeaderText+'</small>';
            }
            else{
                html += jsonData.corpus_header.title;
            }
            html += '<i class="material-icons pull-right">'+jsonData.corpus_header.corpusIcon+'</i>';
            html += '</li>';


            html += '<li class="list-group-item justify-content-between align-items-center">';
            html += ''+jsonData.document_headers.title+'';
            if(jsonData.document_headers.documentHeaderText != ''){
                html += '<br /><br /><span>'+jsonData.document_headers.documentHeaderText+'</span>';
            }

            html += '<i class="material-icons pull-right">'+jsonData.document_headers.documentIcon+'</i>';
            html += '</li>';

            html += '<li class="list-group-item justify-content-between align-items-center">';
            html += ''+jsonData.annotation_headers.title+'';
            if(jsonData.annotation_headers.annotationHeaderText != ''){
                html += '<br /><br /><span>'+jsonData.annotation_headers.annotationHeaderText+'</span>';
            }
            html += '<i class="material-icons pull-right">'+jsonData.annotation_headers.annotationIcon+'</i>';
            html += '</li>';

            html += '</ul>';

            html += '</div>';

            $('#publishCorpusModalSubtitleContent').html(html)
            $('#publicationModal').modal('show');
            if(jsonData.canPublish == false) {
                $('#doPublish').attr("disabled","disabled");
            }
            $('#publicationModal .modal-dialog .modal-content .modal-body').html(html);
        }).catch(function(err) {
            // Run this when promise was rejected via reject()
            console.log(err)
        })
    });

    $(document).on('click', '#doPublish', function(){
        var postData = {}
        if(typeof window.laudatioApp.corpus_id != 'undfined') {
            postData.corpusid = window.laudatioApp.corpus_id;
        }
        else {
            postData.corpusid = $(this).data('corpusid')
        }


        console.log("POSTDATA: "+JSON.stringify(postData))
        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            method: 'POST',
            url: '/api/adminapi/publishCorpus',
            data: postData,
            dataType: "json"
        })
            .done(function(data) {
                if(data.status == "success"){
                    console.log(data.message.publish_corpus_response)
                    $('#alert-laudatio').addClass('alert-success');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.publish_corpus_response)
                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                    });
                }
                else if (data.status == "error"){
                    console.log(data.message.publish_corpus_response)
                    $('#alert-laudatio').addClass('alert-danger');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.publish_corpus_response)

                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                    });
                }
            })
            .fail(function(data) {
                console.log("FAIL : "+data.message.publish_corpus_response)
                $('#alert-laudatio').addClass('alert-danger');
                $('#alert-laudatio .alert-laudatio-message').html(data.message.publish_corpus_response)

                $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert-laudatio").slideUp(500);
                });
            });

    });

    /**
     * Validate Corpus For Publication
     */
    $(document).on('click', '#validateCorpusButton', function () {
        var postData = {}
        postData.corpusid = $('#corpusid').val();
        postData.corpuspath = $('#corpuspath').val()
        console.log("POSTDATA: "+JSON.stringify(postData))
        getValidationData(postData).then(function(data) {
            var json = JSON.parse(data.msg);
            console.log("JSON: "+data.msg)
            var newModaltitle = "Validation results for corpus/"+json.corpusheader;
            $('#myModalLabelValidation').html(newModaltitle);
            $('#myValidatorModal').modal('show');

            var html = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

            html += '<div class="panel panel-default">';
            html += '<div class="panel-heading" role="tab" id="documentHeading">';
            html += '<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#documentsInCorpus" aria-expanded="false" aria-controls="documentsInCorpus">Documents in corpus</a></h4></div>'
            html += '<div id="documentsInCorpus" class="panel-collapse collapse" role="tabpanel" aria-labelledby="documentHeading"><div class="list-group">';
            html +='<ul class="list-group">';
            for(var i = 0; i < json.found_documents.length; i++){
                html += '<li class="list-group-item">'+json.found_documents[i].title+' <i class="material-icons pull-right">check_circle</i></li>';
            }

            var not_found_documents = json.not_found_documents_in_corpus.sort()

            for(var j = 0; j < not_found_documents.length; j++){
                html += '<li class="list-group-item">'+not_found_documents[j]+' <i class="material-icons pull-right">warning</i></li>';
            }
            html += '</ul>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '<div class="panel panel-default">';
            html += '<div class="panel-heading" role="tab" id="annotationHeading">';
            html += '<h4 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#annotationsInCorpus" aria-expanded="false" aria-controls="annotationsInCorpus">Annotations in corpus</a></h4></div>'
            html += '<div id="annotationsInCorpus" class="panel-collapse collapse" role="tabpanel" aria-labelledby="annotationHeading"><div class="list-group">'

            html +='<ul class="list-group">';

            for(var k = 0; k < json.found_annotations_in_corpus.length; k++){
                html += '<li class="list-group-item">'+json.found_annotations_in_corpus[k]+' <i class="material-icons pull-right">check_circle</i></li>';
            }

            var not_found_annotations = json.not_found_annotations_in_corpus.sort()
            for(var l = 0; l < not_found_annotations.length; l++){
                html += '<li class="list-group-item">'+not_found_annotations[l]+' <i class="material-icons pull-right">warning</i></li>';
            }


            html += '</ul>';

            html += '</div>';
            html += '</div>';
            html += '</div>';

            html += '</div>';
            $('.modal-body').html(html);
        }).catch(function(err) {
            // Run this when promise was rejected via reject()
            console.log(err)
        });
    });

    $(document).on('click', '#licenselink', function () {
        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var postData = {};
        postData.uri = "https://creativecommons.org/licenses/by/3.0/";
        $.ajax({
            method: 'POST',
            url: '/api/browseapi/scrapeLicenseDeed',
            data: postData,
            dataType: "json"
        })
            .done(function(data) {
                if(data.status == "success"){
                    $('#license-deed').html(data.message.deedheader+data.message.deedbody+data.message.helppanels)
                }
                else if (data.status == "error"){
                    console.log(data.message.message_delete_response)
                    $('#alert-laudatio').addClass('alert-danger');
                    $('#alert-laudatio .alert-laudatio-message').html(data.message.message_delete_response)

                    $("#alert-laudatio").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert-laudatio").slideUp(500);
                    });
                }
            })
            .fail(function(data) {
                console.log("FAIL : "+data)
            });
    });


    /**
     * DELETE CORPUS
     */
    $(document).on('click', '#checkDeleteCorpusButton',function (){
        var postPublishData = {}


        if(typeof window.laudatioApp != 'undefined') {
            postPublishData.corpusid = window.laudatioApp.corpus_id;
            postPublishData.corpuspath = window.laudatioApp.corpus_path;
            postPublishData.corpusname = window.laudatioApp.corpus_name;
        }
        else {
            postPublishData.corpusid = $(this).data('corpusid');
            postPublishData.corpuspath = $(this).data('corpuspath');
            postPublishData.corpusname = $(this).data('corpusname');
        }

        checkCorpusContent(postPublishData).then(function(publishData){

            //var json = JSON.parse(publishData.msg);
            var jsonData = publishData.msg.checkdata

            var corpusHeader = 0;
            var documentHeaders = 0;
            var annotationHeaders = 0;
            var corpusData = 0;
            var definedLIcense = 0;

            var modal_title = "Do you really want to delete corpus "+postPublishData.corpusname+" ?"
            $('#deleteCorpusModalTitle').html(modal_title);

            if(typeof jsonData.corpusheader != 'undefined' && jsonData.corpusheader != '') {
                corpusHeader = 1;
            }

            if(typeof jsonData.found_documents != 'undefined') {
                documentHeaders = jsonData.found_documents.length;
            }

            if(typeof jsonData.found_annotations_in_corpus != 'undefined') {
                annotationHeaders = jsonData.found_annotations_in_corpus.length;
            }

            var html = '<ul class="list-group list-group-flush mb-3">';
            html += '<li class="list-group-item">('+corpusHeader+') Corpus Header</li>'

            if(documentHeaders < 2){
                html += '<li class="list-group-item">('+documentHeaders+') Document Header</li>'
            }
            else{
                html += '<li class="list-group-item">('+documentHeaders+') Document Headers</li>'
            }

            if(annotationHeaders < 2){
                html += '<li class="list-group-item">('+annotationHeaders+') Annotation Header</li>'
            }
            else{
                html += '<li class="list-group-item">('+annotationHeaders+') Annotation Headers</li>'
            }

            html += '<li class="list-group-item">(0) Corpus Data Format</li>'
            html += '<li class="list-group-item">(0) Defined License</li>'

            html += '</ul>';

            console.log(jsonData);
            $('#corpusContent').html(html);
        }).catch(function(err) {
            // Run this when promise was rejected via reject()
            console.log(err)
        })
    });


    $(document).on('click', '.headerDeleteTrashcan',function () {
        var postDeleteData = {}
        var toBeDeleted = []

        if (typeof window.laudatioApp != 'undefined') {
            postDeleteData.corpusid = window.laudatioApp.corpus_id;
            postDeleteData.path = window.Laravel.directorypath;
        }
        else {
            postDeleteData.corpusid = $(this).data('corpusid');
        }

        postDeleteData.auth_user_name = $('#auth_user_name').val();
        postDeleteData.auth_user_id = $('#auth_user_id').val();
        postDeleteData.auth_user_email = $('#auth_user_email').val();

        var checkedId = $(this).parent().attr("id");
        var checkedIdArray = checkedId.split('§');
        var deletionObject = {}
        deletionObject.fileName = checkedIdArray[1];
        deletionObject.databaseId = checkedIdArray[2];
        toBeDeleted.push(deletionObject);

        postDeleteData.tobedeleted = toBeDeleted;

        var contentType = '';
        if(postDeleteData.path.indexOf('TEI-HEADERS/corpus') > -1) {
            contentType = 'deleteCorpusContent';
        }
        else if(postDeleteData.path.indexOf('TEI-HEADERS/document') > -1) {
            contentType = 'deleteDocumentContent';
        }
        else if(postDeleteData.path.indexOf('TEI-HEADERS/annotation') > -1) {
            contentType = 'deleteAnnotationContent';
        }

        var trashcan = $(this);
        deleteCorpusContent(postDeleteData,contentType).then(function(data){
            trashcan.closest("tr").remove();
        }).catch(function(err) {
            // Run this when promise was rejected via reject()
            console.log(err)
        });

    });



    $(document).on('click', '#deleteSelectedCorpusButton',function () {
        var postDeleteData = {}
        var toBeDeleted = []
        var checkedIds = []

        if (typeof window.laudatioApp != 'undefined') {
            postDeleteData.corpusid = window.laudatioApp.corpus_id;
            postDeleteData.path = window.Laravel.directorypath;
        }
        else {
            postDeleteData.corpusid = $(this).data('corpusid');
        }

        postDeleteData.auth_user_name = $('#auth_user_name').val();
        postDeleteData.auth_user_id = $('#auth_user_id').val();
        postDeleteData.auth_user_email = $('#auth_user_email').val();

        $('#corpusFileList input:checked').each(function() {
            var checkedId = $(this).attr("id");
            if (checkedId != 'selectAll_corpusEdit') {
                var checkedIdArray = checkedId.split('§');
                checkedIds.push(checkedId)
                var deletionObject = {}
                deletionObject.fileName = checkedIdArray[1];
                deletionObject.databaseId = checkedIdArray[2];
                toBeDeleted.push(deletionObject);
            }
        });


        postDeleteData.tobedeleted = toBeDeleted;

        var currentAnnotationCount = parseInt($('#corpusCount span').html());
        deleteCorpusContent(postDeleteData,'deleteCorpusContent').then(function(postDeleteData){
            var deletedAnnotations = removeDeletedElements(checkedIds);
            $('#corpusCount span').html(currentAnnotationCount-deletedAnnotations);
        }).catch(function(err) {
            // Run this when promise was rejected via reject()
            console.log(err)
        });

    });




    $(document).on('click', '#deleteSelectedDocumentsButton',function (){
        var postDeleteData = {}
        var toBeDeleted = []
        var checkedIds = []

        if(typeof window.laudatioApp != 'undefined') {
            postDeleteData.corpusid = window.laudatioApp.corpus_id;
            postDeleteData.path = window.Laravel.directorypath;
        }
        else {
            postDeleteData.corpusid = $(this).data('corpusid');
        }

        postDeleteData.auth_user_name = $('#auth_user_name').val();
        postDeleteData.auth_user_id = $('#auth_user_id').val();
        postDeleteData.auth_user_email = $('#auth_user_email').val();

        $('#documentFileList input:checked').each(function() {
            var checkedId = $(this).attr("id");
            if(checkedId != 'selectAll_documentEdit'){
                var checkedIdArray = checkedId.split('§');
                checkedIds.push(checkedId);
                var deletionObject = {}
                deletionObject.fileName = checkedIdArray[1];
                deletionObject.databaseId = checkedIdArray[2];
                toBeDeleted.push(deletionObject);
            }
        });

        postDeleteData.tobedeleted = toBeDeleted;


        var currentAnnotationCount = parseInt($('#documentCount span').html());
        deleteCorpusContent(postDeleteData,'deleteDocumentContent').then(function(postDeleteData){
            var deletedAnnotations = removeDeletedElements(checkedIds);
            $('#documentCount span').html(currentAnnotationCount-deletedAnnotations);
        }).catch(function(err) {
            // Run this when promise was rejected via reject()
            console.log(err)
        });

    });

    $(document).on('click', '#deleteSelectedAnnotationsButton',function () {
        var postDeleteData = {}
        var toBeDeleted = []
        var checkedIds = []

        if (typeof window.laudatioApp != 'undefined') {
            postDeleteData.corpusid = window.laudatioApp.corpus_id;
            postDeleteData.path = window.Laravel.directorypath;
        }
        else {
            postDeleteData.corpusid = $(this).data('corpusid');
        }

        postDeleteData.auth_user_name = $('#auth_user_name').val();
        postDeleteData.auth_user_id = $('#auth_user_id').val();
        postDeleteData.auth_user_email = $('#auth_user_email').val();

        var that = $(this);
        $('#annotationFileList input:checked').each(function() {
            var checkedId = $(this).attr("id");

            if (checkedId != 'selectAll_annotationEdit') {
                var checkedIdArray = checkedId.split('§');
                checkedIds.push(checkedId);
                var deletionObject = {}
                deletionObject.fileName = checkedIdArray[1];
                deletionObject.databaseId = checkedIdArray[2];
                toBeDeleted.push(deletionObject);
            }
        });

        postDeleteData.tobedeleted = toBeDeleted;

        var currentAnnotationCount = parseInt($('#annotationCount span').html());
        deleteCorpusContent(postDeleteData,'deleteAnnotationContent').then(function(postDeleteData){
            var deletedAnnotations = removeDeletedElements(checkedIds);
            $('#annotationCount span').html(currentAnnotationCount-deletedAnnotations);
        }).catch(function(err) {
            // Run this when promise was rejected via reject()
            console.log(err)
        });
    });




})

/** FUNCTIONS **/

function removeDeletedElements(checkedIds) {

    for( var i = 0; i < checkedIds.length; i++) {
        $('#'+$.escapeSelector(checkedIds[i])).closest("tr").remove();
    }//end for

    return i;
}


/**
 * Validate headers promise
 * @param postData
 * @returns {Promise}
 */
function getValidationData(postData) {
    return new Promise(function(resolve, reject) {

        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/api/adminapi/validateHeaders',
            type:"POST",
            data: postData,
            async: true,
            statusCode: {
                500: function () {
                    alert("server down");
                }
            },
            success: function(data) {
                resolve(data) // Resolve promise and go to then()
            },
            error: function(err) {
                reject(err) // Reject the promise and go to catch()
            }
        })
    });
}

/**
 * preparepublication promise
 * @param postData
 * @returns {Promise}
 */
function getPublishTestData(postData) {
    return new Promise(function(resolve, reject) {

        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/api/adminapi/preparePublication',
            type:"POST",
            data: postData,
            async: true,
            statusCode: {
                500: function () {
                    alert("server down");
                }
            },
            success: function(data) {
                resolve(data) // Resolve promise and go to then()
            },
            error: function(err) {
                reject(err) // Reject the promise and go to catch()
            }
        })
    });
}


function checkCorpusContent(postData) {
    return new Promise(function(resolve, reject) {

        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/api/adminapi/checkCorpusContent',
            type:"POST",
            data: postData,
            async: true,
            statusCode: {
                500: function () {
                    alert("server down");
                }
            },
            success: function(data) {
                resolve(data) // Resolve promise and go to then()
            },
            error: function(err) {
                reject(err) // Reject the promise and go to catch()
            }
        })
    });
}

function deleteCorpusContent(postData, documentType) {
    return new Promise(function(resolve, reject) {

        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var postUri = '/api/adminapi/'+documentType;

        $.ajax({
            url: postUri,
            type:"POST",
            data: postData,
            async: true,
            statusCode: {
                500: function () {
                    alert("server down");
                }
            },
            success: function(data) {
                resolve(data) // Resolve promise and go to then()
            },
            error: function(err) {
                reject(err) // Reject the promise and go to catch()
            }
        })
    });
}

/**
 * get Citation Data promise
 * @param postData
 * @returns {Promise}
 */
function getCitationData(postData) {
    return new Promise(function(resolve, reject) {

        var token = $('#_token').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/download/citation',
            type:"POST",
            data: postData,
            async: true,
            statusCode: {
                500: function () {
                    alert("server down");
                }
            },
            success: function(data) {
                resolve(data) // Resolve promise and go to then()
            },
            error: function(err) {
                reject(err) // Reject the promise and go to catch()
            }
        })
    });
}

