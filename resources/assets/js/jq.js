/**
 * Created by rolfguescini on 28.03.18.
 */
$(function(){

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
            console.log(window.Laravel.directorypath)
            var previews = $('#previews').detach();
            previews.html("");
            previews.appendTo($('#tabcontainer'));
        }
    });

    $('nav.headernav a[data-headertype ="document"]').bind('click', function (e) {
        if(typeof window.Laravel != 'undefined') {
            var oldPath = window.Laravel.directorypath.substr(0, window.Laravel.directorypath.indexOf('/TEI'))
            window.Laravel.directorypath = oldPath + '/TEI-HEADERS/document';
            console.log(window.Laravel.directorypath)
            var previews = $('#previews').detach();
            previews.html("");
            previews.appendTo($('#tabcontainer'));
        }
    });

    $('nav.headernav a[data-headertype ="annotation"]').bind('click', function (e) {
        if(typeof window.Laravel != 'undefined') {
            var oldPath = window.Laravel.directorypath.substr(0, window.Laravel.directorypath.indexOf('/TEI'))
            window.Laravel.directorypath = oldPath + '/TEI-HEADERS/annotation';
            console.log(window.Laravel.directorypath)
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


})