/**
 * Created by rolfguescini on 28.03.18.
 */
$(function(){

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


    /**
     * Hide error banner initially
     */
    $("#alert-laudatio").hide();
    if($("nav").find("a[data-headertype ='corpus']").hasClass('active')){
        window.Laravel.directorypath += '/TEI-HEADERS/corpus';
    }
    else if($("nav").find("a[data-headertype ='document']").hasClass('active')){
        window.Laravel.directorypath += '/TEI-HEADERS/document';
    }
    else if($("nav").find("a[data-headertype ='annotation']").hasClass('active')){
        window.Laravel.directorypath += '/TEI-HEADERS/annotation';
    }
    //alert(window.Laravel.directorypath)

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

    /**
     * switch between file list and upload view
     */

    $(document).on('click','.uploadcontrols',function(){
        var headerTypeArray = $(this).attr('id').split('_');
        var headerType = headerTypeArray[0];
        var headerAction = headerTypeArray[1];
        if(headerAction.indexOf('Upload') > -1) {
            $('#'+headerType+'Uploader').css('display','block');
            $('#'+headerType+'FileList').css('display','none');
        }
        else{
            $('#'+headerType+'Uploader').css('display','none');
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
                console.log(data)
                if(data.success){
                    var newUri = window.location.origin+data.redirect
                    history.pushState({}, null, newUri);
                    location.reload();
                }
                else{
                    console.log(data.message)
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
})