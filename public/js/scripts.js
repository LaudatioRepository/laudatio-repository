/*!
 * laudatio
 *
 *
 * @author PHMU Webdesign
 * @version 0.1.0
 * Copyright 2018.  licensed.
 */
$('.clear-search').on('click', function() {
    $(this).closest('.input-group').find('input').val('')
});
$('.collapse').on('show.bs.collapse', function () {
    $(this).prev().children('.collapse-indicator').css('transform','initial');
});
$('.collapse').on('hide.bs.collapse', function () {
    $(this).prev().children('.collapse-indicator').css('transform','rotate(180deg)');
});
// fileUpload library "DropzoneJS"
// Documentation: http://www.dropzonejs.com/

// prevent double dropzones
Dropzone.autoDiscover = false;

var previewNode = document.querySelector("#corpusUploadTemplate");
if(previewNode) {

    // see documentation: http://www.dropzonejs.com/
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);
    dropUrl = "/corpusprojects/upload";

    // init dropzoneJS
    var corpusUpload = new Dropzone(document.body, { // Make the whole body a dropzone
        url: dropUrl, // Set the url
        headers: {"X-Csrf-Token": window.Laravel.csrfToken},parameters: {"_csrf_token": window.Laravel.csrfToken,'directorypath': window.Laravel.directorypath,'corpusid': window.Laravel.corpusid,'filedata': window.Laravel.filedata},sending: function(file, xhr, formData) {
            formData.append("_csrf_token", window.Laravel.csrfToken);formData.append("directorypath", window.Laravel.directorypath);formData.append("corpusid", window.Laravel.corpusid);formData.append("filedata", window.Laravel.filedata);},paramName: "formats",
        parallelUploads: 1,
        uploadMultiple: false,
        previewTemplate: previewTemplate,
        autoQueue: true, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: '.uploadArea' // Define the element that should be used as click trigger to select files.
    });

    // DropzoneJS event methods
    corpusUpload.on("processing", function(file) {
        if(window.Laravel.directorypath.indexOf("CORPUS-DATA") > -1) {
            corpusUpload.options.url = "/corpusprojects/uploadFiles"
        }
        else if(window.Laravel.directorypath.indexOf("images") > -1) {
            corpusUpload.options.url = "/corpusprojects/uploadCorpusImage"
        }
        else{
            corpusUpload.options.url = "/corpusprojects/upload"
        }

        $(file.previewElement).find('.uploadStatusText').text('Uploading');
        $(file.previewElement).find('.uploadStatusIcons').find('.uploadCancel').removeClass('hidden');
    });

    corpusUpload.on("success", function(file) {
        $(file.previewElement).find('.uploadStatusText').text('Completed');
        $(file.previewElement).find('.uploadStatusIcons').children().addClass('hidden');
        $(file.previewElement).find('.uploadSuccessIcon').removeClass('hidden');
    });

    corpusUpload.on("complete", function() {
        // validate and activate the "finish upload"-button
        $('.uploadActions .btn').removeClass('disabled');
    });

    corpusUpload.on("error", function(file,response) {
        var errMsg = ""
        if(typeof response != 'undefined' ){
            errMsg += '<ul class="list-unstyled">';
            for(var i = 0; i < response.length; i++) {
                var notification = response[i]
                errMsg += '<li class="error text-danger">'+notification.error;
                errMsg += "<ul>";
                for(var j = 0; j < notification.payload.length; j++) {
                    errMsg += "<li>"+notification.payload[j]+"</li>";
                }
                errMsg += "</ul>";
                errMsg += "</li>";
            }

            errMsg += "</ul>";
        }
        $('#alert-laudatio').addClass('alert-danger');
        $('#alert-laudatio').html(errMsg)

        $("#alert-laudatio").fadeTo(2000, 2000).slideUp(500, function(){

        });
        $(file.previewElement).find('.uploadStatusText').html(errMsg);
        $(file.previewElement).find('.error.text-14.text-danger').html('');
        $(file.previewElement).find('.uploadStatusIcons').children().addClass('hidden');
        $(file.previewElement).find('.uploadErrorIcon').removeClass('hidden');
    });

    corpusUpload.on("processingmultiple", function(elementList) {
        $('.uploadLength').removeClass('hidden');
        $('.uploadLength').text(elementList.length + ' File(s) queued.');
    });

    // init click event for cancel-func on body, because cancel button is not loaded initially due to preview-template-removal at start
    $('body').on('click', '.uploadCancel', function () {
        corpusUpload.removeAllFiles(true);
    });
}




var inputList = ['#formCorpusFormats', '#formAnnotationsFormats'];
var customPlaceholders = ['"ANNIS"','"ANNIS"'];

for(var h = 0; h < inputList.length; h++) {
    $(inputList[h]).flexdatalist({
        minLength: 0
    });
    let i = h
    $(inputList[i] + '-flexdatalist').attr('placeholder', customPlaceholders[i]);

    $(inputList[i]).on('change:flexdatalist', function(event, set, options) {
        if($(inputList[i]).flexdatalist('value').length > 0) {
            $(inputList[i] + '-flexdatalist').attr('placeholder', '');
        } else {
            $(inputList[i] + '-flexdatalist').attr('placeholder', customPlaceholders[i]);
        }
    });
}

// EDIT button in corpusProject Edits
$('.corpusProject .corpusProject-startEdit').click(function() {
    let corpusProject = $(this).closest('.corpusProject');
    corpusProject.find('.corpusProject-save').toggleClass('hidden');
    corpusProject.find('.corpusProject-edit').toggleClass('hidden');

    let title = corpusProject.find('.corpusProject-title').text().trim();
    let description = corpusProject.find('.corpusProject-description').text().trim();

    corpusProject.find('.corpusProject-description-edit').val(description);
    corpusProject.find('.corpusProject-title-edit').val(title);
});

// SAVE button in corpusProject Edits
$('.corpusProject .corpusProject-saveEdit').click(function() {
    let corpusProject = $(this).closest('.corpusProject');
    corpusProject.find('.corpusProject-save').toggleClass('hidden');
    corpusProject.find('.corpusProject-edit').toggleClass('hidden');

    // -- -- -- --
    // Here you can submit the changes to the form to the backend of whatever
    // -- -- -- --
});

// CANCEL button in corpusProject Edits
$('.corpusProject .corpusProject-endEdit').click(function() {
    let corpusProject = $(this).closest('.corpusProject');
    corpusProject.find('.corpusProject-save').toggleClass('hidden');
    corpusProject.find('.corpusProject-edit').toggleClass('hidden');
});
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(() => {

    // initialize unslider-carousel for the slides on the home page
    $('.homeCarousel').unslider({
        infinite: true,
        arrows: {
            prev: '<a class="unslider-arrow prev"><i class="fa fa-2x fa-angle-left text-wine-trans"></i></a>',
            next: '<a class="unslider-arrow next"><i class="fa fa-2x fa-angle-right text-wine-trans"></i></a>',
        }
    });

    // after carousel initialization, match the height of the two boxes on home page (flexbox due to col-row-grid not usable)
    $(function() {
        $('.matchedHeight').matchHeight();
    });


});
const suggestions = [
    {
        "value": "Curry",
        "data": "Noreen"
    },
    {
        "value": "Sanders",
        "data": "Hogan"
    },
    {
        "value": "Cherry",
        "data": "Althea"
    },
    {
        "value": "Alyce",
        "data": "Adela"
    },
    {
        "value": "Davidson",
        "data": "Misty"
    },
    {
        "value": "Dorothea",
        "data": "Cornelia"
    },
    {
        "value": "Mathis",
        "data": "Stein"
    },
    {
        "value": "Marsh",
        "data": "Eve"
    },
    {
        "value": "Danielle",
        "data": "Mcfarland"
    },
    {
        "value": "Desiree",
        "data": "Pacheco"
    },
    {
        "value": "Knox",
        "data": "Guerrero"
    },
    {
        "value": "Myra",
        "data": "Berta"
    },
    {
        "value": "Kellie",
        "data": "Gretchen"
    },
    {
        "value": "Jeanette",
        "data": "Andrea"
    },
    {
        "value": "Workman",
        "data": "Ballard"
    },
    {
        "value": "Moran",
        "data": "Rebekah"
    },
    {
        "value": "Alana",
        "data": "Leanne"
    },
    {
        "value": "Suarez",
        "data": "Concetta"
    },
    {
        "value": "Felecia",
        "data": "Zamora"
    },
    {
        "value": "Flowers",
        "data": "Noel"
    },
    {
        "value": "Thornton",
        "data": "Colette"
    },
    {
        "value": "Susanna",
        "data": "Roy"
    },
    {
        "value": "Hatfield",
        "data": "Skinner"
    },
    {
        "value": "Blankenship",
        "data": "Fisher"
    },
    {
        "value": "Mitchell",
        "data": "Bryan"
    }
]

// Initialize autocompletion for every filter form input

$('#formCorpusTitle').autocomplete({
    lookup: suggestions
});
$('#formCorpusLanguage').autocomplete({
    lookup: suggestions
});
$('#formCorpusPublisher').autocomplete({
    lookup: suggestions
});
$('#formCorpusLicenses').autocomplete({
    lookup: suggestions
});


$('#formDocumentsTitle').autocomplete({
    lookup: suggestions
});
$('#formDocumentsAuthor').autocomplete({
    lookup: suggestions
});
$('#formDocumentsLanguage').autocomplete({
    lookup: suggestions
});
$('#formDocumentsPlace').autocomplete({
    lookup: suggestions
});


$('#formAnnotationsTitle').autocomplete({
    lookup: suggestions
});
$('#formAnnotationsLanguage').autocomplete({
    lookup: suggestions
});

// After DOM is ready ...
$(document).ready(() => {


    /**
     * fix to ensure that submit buttons aren't klickable before the toBeValidated-checkbox is checked
     */
    if( $(':input.toCheckValidation').length && $(':input.toBeValidated-checkbox').length && $(document).find('input.toBeValidated-checkbox:not(:checked)')){
        if(!$('.toCheckValidation').hasClass('disabled')) {
            $('.toCheckValidation').addClass('disabled')
        }

        if($(':input[type="submit"]').prop('disabled', false)) {
            $(':input[type="submit"]').prop('disabled', true);
        }

    }

    // validate all text inputs in corresponding form, if they are empty. If not, activate submit button
    $('input.toBeValidated').blur(function(){
        let parentForm = $(this).closest('form')
        let submitBtn = $(parentForm).find('.toCheckValidation')

        let emptyFields = $(parentForm).find('input.toBeValidated').filter(function() {
            return $.trim(this.value) === "";
        });

        if(emptyFields.length > 0) {
            if(!$(submitBtn).hasClass('disabled')) {
                $(submitBtn).addClass('disabled')
            }
        } else {
            $(submitBtn).removeClass('disabled')
        }
    });


    // validate all checkbox inputs in corresponding form, if they are checked. If, activate submit button
    $('input.toBeValidated-checkbox').change(function(){
        let parentForm = $(this).closest('form')
        let submitBtn = $(parentForm).find('.toCheckValidation')

        let uncheckedBoxes = $(parentForm).find('input.toBeValidated-checkbox:not(:checked)')

        if(uncheckedBoxes.length > 0) {
            if(!$(submitBtn).hasClass('disabled')) {
                $(submitBtn).addClass('disabled')
            }
        } else {
            $(submitBtn).removeClass('disabled')
            $('.toCheckValidation').prop("disabled", false)
        }
    });


    // Button Validation for Admin - Publish - Tables -- Select/Delete All
    $('.documents-table input:checkbox').change(function(){
        if($('.documents-table tbody input:checkbox:checked').length > 0) {
            $('.documents-table tfoot button').removeClass('disabled');
        } else {
            $('.documents-table tfoot button').addClass('disabled');
        }
    });


    // Admin - Publish - Modal validate if all checks are passed
    // $('#publishCorpusModal ...ELEMENTS_TO_TEST_ON...').change(function() {
    //   // here goes your code for deciding whether to activate the "publish"-button or not

    //   // activate the "publish"-button
    //   $('#publishCorpusModal modal-footer button').removeClass('disabled');
    // });


    // Admin - Publish - Preview validation
    // Here you should define your own rules, whether to activate the "preview"-button
    // the element to change:
    // $('#corpusMainActions .corpusPreview').removeClass('disabled');

});
// fileUpload library "DropzoneJS"
// Documentation: http://www.dropzonejs.com/

function toggleViewUpload() {
    // hide enter-upload button
    $('.enterLogoUpload').toggleClass('hidden');
    // show leave-upload button
    $('.leaveLogoUpload').toggleClass('hidden');
    // hide upload area
    $('.uploadArea').toggleClass('hidden');
    // show upload placeholder
    $('.uploadPlaceholder').toggleClass('hidden');
}

function toggleUploadStatus() {
    // display the preview and progress things
    $('.logoUpload-end').toggleClass('hidden');
    // hide the default view
    $('.logoUpload-start').toggleClass('hidden');
}

// prevent double dropzones
Dropzone.autoDiscover = false;


$('#toTop').on("click", function(event) {
    event.preventDefault();
    $("html, body").animate(
        {
            scrollTop: $('#browseapp').offset().top
        },
        500
    );
});
//# sourceMappingURL=data:application/json;charset=utf8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImNvcnB1c1VwbG9hZC5qcyIsImNsZWFyU2VhcmNoaW5wdXQuanMiLCJjb2xsYXBzZVJvdGF0b3IuanMiLCJkYXRhTGlzdHMuanMiLCJlZGl0Q29ycHVzUHJvamVjdC5qcyIsImVuYWJsZVRvb2x0aXBzLmpzIiwiaG9tZUNhcm91c2VsLmpzIiwiaW5wdXRBdXRvY29tcGxldGUuanMiLCJsb2dvVXBsb2FkLmpzIiwiaW5wdXRTdWJtaXRWYWxpZGF0aW9uLmpzIiwicmFuZ2VTbGlkZXIuanMiLCJzbW9vdGhTY3JvbGxUby5qcyIsInRhYmxlU2VsZWN0QWxsLmpzIl0sIm5hbWVzIjpbIiQiLCJvbiIsInRoaXMiLCJjbG9zZXN0IiwiZmluZCIsInZhbCIsInByZXYiLCJjaGlsZHJlbiIsImNzcyIsIkRyb3B6b25lIiwiYXV0b0Rpc2NvdmVyIiwicHJldmlld05vZGUiLCJkb2N1bWVudCIsInF1ZXJ5U2VsZWN0b3IiLCJpZCIsInByZXZpZXdUZW1wbGF0ZSIsInBhcmVudE5vZGUiLCJpbm5lckhUTUwiLCJyZW1vdmVDaGlsZCIsImNvcnB1c1VwbG9hZCIsImJvZHkiLCJ1cmwiLCJwYXJhbGxlbFVwbG9hZHMiLCJ1cGxvYWRNdWx0aXBsZSIsImF1dG9RdWV1ZSIsInByZXZpZXdzQ29udGFpbmVyIiwiY2xpY2thYmxlIiwiZmlsZSIsInByZXZpZXdFbGVtZW50IiwidGV4dCIsInJlbW92ZUNsYXNzIiwiYWRkQ2xhc3MiLCJlbGVtZW50TGlzdCIsImxlbmd0aCIsInJlbW92ZUFsbEZpbGVzIiwiaW5wdXRMaXN0IiwiY3VzdG9tUGxhY2Vob2xkZXJzIiwiaCIsImZsZXhkYXRhbGlzdCIsIm1pbkxlbmd0aCIsImkiLCJhdHRyIiwiZXZlbnQiLCJzZXQiLCJvcHRpb25zIiwiY2xpY2siLCJjb3JwdXNQcm9qZWN0IiwidG9nZ2xlQ2xhc3MiLCJ0aXRsZSIsInRyaW0iLCJkZXNjcmlwdGlvbiIsInRvb2x0aXAiLCJyZWFkeSIsInVuc2xpZGVyIiwiaW5maW5pdGUiLCJhcnJvd3MiLCJuZXh0IiwibWF0Y2hIZWlnaHQiLCJzdWdnZXN0aW9ucyIsInZhbHVlIiwiZGF0YSIsInRvZ2dsZVZpZXdVcGxvYWQiLCJ0b2dnbGVVcGxvYWRTdGF0dXMiLCJhdXRvY29tcGxldGUiLCJsb29rdXAiLCJibHVyIiwicGFyZW50Rm9ybSIsInN1Ym1pdEJ0biIsImZpbHRlciIsImhhc0NsYXNzIiwiY2hhbmdlIiwibG9nb1VwbG9hZCIsIm1heEZpbGVzIiwicmVzcG9uc2UiLCJoaWRkZW5GaWxlSW5wdXQiLCJyYW5nZVNsaWRlckxpc3QiLCJlbCIsImdldEVsZW1lbnRCeUlkIiwic3R5bGUiLCJoZWlnaHQiLCJtYXJnaW4iLCJub1VpU2xpZGVyIiwiY3JlYXRlIiwiYW5pbWF0ZSIsInN0YXJ0IiwibGltaXQiLCJjb25uZWN0Iiwib3JpZW50YXRpb24iLCJiZWhhdmlvdXIiLCJzdGVwIiwicmFuZ2UiLCJtaW4iLCJtYXgiLCJwYWRkaW5nTWluIiwicGFkZGluZ01heCIsInZhbHVlcyIsImhhbmRsZSIsIk1hdGgiLCJyb3VuZCIsInByZXZlbnREZWZhdWx0IiwiY29uc29sZSIsImxvZyIsInNjcm9sbFRvcCIsIm9mZnNldCIsInRvcCIsImUiLCJwcm9wIiwiY2hlY2tlZCJdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7QUFPQSxHQ1BBQSxFQUFBLGlCQUFBQyxHQUFBLFFBQUEsV0FDQUQsRUFBQUUsTUFBQUMsUUFBQSxnQkFBQUMsS0FBQSxTQUFBQyxJQUFBLE1DREFMLEVBQUEsYUFBQUMsR0FBQSxtQkFBQSxXQUNBRCxFQUFBRSxNQUFBSSxPQUFBQyxTQUFBLHVCQUFBQyxJQUFBLFlBQUEsYUFFQVIsRUFBQSxhQUFBQyxHQUFBLG1CQUFBLFdBQ0FELEVBQUFFLE1BQUFJLE9BQUFDLFNBQUEsdUJBQUFDLElBQUEsWUFBQSxvQkZBQUMsU0FBQUMsY0FBQSxFQUVBQyxZQUFBQyxTQUFBQyxjQUFBLHlCQUNBLENBR0FGLFlBQUFHLEdBQUEsR0FDQSxJQUFBQyxnQkFBQUosWUFBQUssV0FBQUMsVUFDQU4sWUFB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QW9DLEVBQUFLLFdBQUFoRixHQUFBLFNBQUEsU0FBQThGLEVBQUFDLEdBQ0FBLEVBQ0FGLEVBQUE3RSxVQUFBZ0YsS0FBQUMsTUFBQUgsRUFBQUMsSUFFQUgsRUFBQTVFLFVBQUFnRixLQUFBQyxNQUFBSCxFQUFBQyxNQUlBcEIsRUFBQUssV0FBQWhGLEdBQUEsU0FBQSxXQUVBLElBQUFpRSxFQUFBbEUsRUFBQTRFLEdBQUF6RSxRQUFBLFFBQ0FILEVBQUFrRSxHQUFBOUQsS0FBQSxrQkFBQTBCLFlBQUEsZUN4Q0E5QixFQUFBLFVBQUFDLEdBQUEsUUFBQSxTQUFBeUMsR0FDQUEsRUFBQXlELGlCQUNBQyxRQUFBQyxJQUFBLE1BQ0FyRyxFQUFBLGNBQUFtRixTQUVBbUIsVUFBQXRHLEVBQUEsa0JBQUF1RyxTQUFBQyxLQUVBLE9DUEF4RyxFQUFBLHlCQUFBNkMsTUFBQSxTQUFBNEQsR0FDQXpHLEVBQUFFLE1BQUFDLFFBQUEsU0FBQUMsS0FBQSxxQkFBQXNHLEtBQUEsVUFBQXhHLEtBQUF5RyIsImZpbGUiOiJzY3JpcHRzLm1pbi5qcyIsInNvdXJjZXNDb250ZW50IjpbIi8vIGZpbGVVcGxvYWQgbGlicmFyeSBcIkRyb3B6b25lSlNcIlxuLy8gRG9jdW1lbnRhdGlvbjogaHR0cDovL3d3dy5kcm9wem9uZWpzLmNvbS9cblxuLy8gcHJldmVudCBkb3VibGUgZHJvcHpvbmVzXG5Ecm9wem9uZS5hdXRvRGlzY292ZXIgPSBmYWxzZTtcblxudmFyIHByZXZpZXdOb2RlID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcIiNjb3JwdXNVcGxvYWRUZW1wbGF0ZVwiKTtcbmlmKHByZXZpZXdOb2RlKSB7XG5cbiAgLy8gc2VlIGRvY3VtZW50YXRpb246IGh0dHA6Ly93d3cuZHJvcHpvbmVqcy5jb20vXG4gIHByZXZpZXdOb2RlLmlkID0gXCJcIjtcbiAgdmFyIHByZXZpZXdUZW1wbGF0ZSA9IHByZXZpZXdOb2RlLnBhcmVudE5vZGUuaW5uZXJIVE1MO1xuICBwcmV2aWV3Tm9kZS5wYXJlbnROb2RlLnJlbW92ZUNoaWxkKHByZXZpZXdOb2RlKTtcblxuICAvLyBpbml0IGRyb3B6b25lSlNcbiAgdmFyIGNvcnB1c1VwbG9hZCA9IG5ldyBEcm9wem9uZShkb2N1bWVudC5ib2R5LCB7IC8vIE1ha2UgdGhlIHdob2xlIGJvZHkgYSBkcm9wem9uZVxuICAgIHVybDogXCJodHRwOi8vbG9jYWxob3N0OjM1MDBcIiwgLy8gU2V0IHRoZSB1cmxcbiAgICBwYXJhbGxlbFVwbG9hZHM6IDIwLFxuICAgIHVwbG9hZE11bHRpcGxlOiB0cnVlLFxuICAgIHByZXZpZXdUZW1wbGF0ZTogcHJldmlld1RlbXBsYXRlLFxuICAgIGF1dG9RdWV1ZTogdHJ1ZSwgLy8gTWFrZSBzdXJlIHRoZSBmaWxlcyBhcmVuJ3QgcXVldWVkIHVudGlsIG1hbnVhbGx5IGFkZGVkXG4gICAgcHJldmlld3NDb250YWluZXI6IFwiI3ByZXZpZXdzXCIsIC8vIERlZmluZSB0aGUgY29udGFpbmVyIHRvIGRpc3BsYXkgdGhlIHByZXZpZXdzXG4gICAgY2xpY2thYmxlOiAnLnVwbG9hZEFyZWEnIC8vIERlZmluZSB0aGUgZWxlbWVudCB0aGF0IHNob3VsZCBiZSB1c2VkIGFzIGNsaWNrIHRyaWdnZXIgdG8gc2VsZWN0IGZpbGVzLlxuICB9KTtcblxuICAvLyBEcm9wem9uZUpTIGV2ZW50IG1ldGhvZHNcbiAgY29ycHVzVXBsb2FkLm9uKFwicHJvY2Vzc2luZ1wiLCBmdW5jdGlvbihmaWxlKSB7XG4gICAgJChmaWxlLnByZXZpZXdFbGVtZW50KS5maW5kKCcudXBsb2FkU3RhdHVzVGV4dCcpLnRleHQoJ1VwbG9hZGluZycpO1xuICAgICQoZmlsZS5wcmV2aWV3RWxlbWVudCkuZmluZCgnLnVwbG9hZFN0YXR1c0ljb25zJykuZmluZCgnLnVwbG9hZENhbmNlbCcpLnJlbW92ZUNsYXNzKCdoaWRkZW4nKTtcbiAgfSk7XG5cbiAgY29ycHVzVXBsb2FkLm9uKFwic3VjY2Vzc1wiLCBmdW5jdGlvbihmaWxlKSB7XG4gICAgJChmaWxlLnByZXZpZXdFbGVtZW50KS5maW5kKCcudXBsb2FkU3RhdHVzVGV4dCcpLnRleHQoJ0NvbXBsZXRlZCcpO1xuICAgICQoZmlsZS5wcmV2aWV3RWxlbWVudCkuZmluZCgnLnVwbG9hZFN0YXR1c0ljb25zJykuY2hpbGRyZW4oKS5hZGRDbGFzcygnaGlkZGVuJyk7XG4gICAgJChmaWxlLnByZXZpZXdFbGVtZW50KS5maW5kKCcudXBsb2FkU3VjY2Vzc0ljb24nKS5yZW1vdmVDbGFzcygnaGlkZGVuJyk7XG4gIH0pO1xuXG4gIGNvcnB1c1VwbG9hZC5vbihcImNvbXBsZXRlXCIsIGZ1bmN0aW9uKCkge1xuICAgIC8vIHZhbGlkYXRlIGFuZCBhY3RpdmF0ZSB0aGUgXCJmaW5pc2ggdXBsb2FkXCItYnV0dG9uXG4gICAgJCgnLnVwbG9hZEFjdGlvbnMgLmJ0bicpLnJlbW92ZUNsYXNzKCdkaXNhYmxlZCcpO1xuICB9KTtcblxuICBjb3JwdXNVcGxvYWQub24oXCJlcnJvclwiLCBmdW5jdGlvbihmaWxlKSB7XG4gICAgJChmaWxlLnByZXZpZXdFbGVtZW50KS5maW5kKCcudXBsb2FkU3RhdHVzVGV4dCcpLnRleHQoJycpO1xuICAgICQoZmlsZS5wcmV2aWV3RWxlbWVudCkuZmluZCgnLnVwbG9hZFN0YXR1c0ljb25zJykuY2hpbGRyZW4oKS5hZGRDbGFzcygnaGlkZGVuJyk7XG4gICAgJChmaWxlLnByZXZpZXdFbGVtZW50KS5maW5kKCcudXBsb2FkRXJyb3JJY29uJykucmVtb3ZlQ2xhc3MoJ2hpZGRlbicpO1xuICB9KTtcblxuICBjb3JwdXNVcGxvYWQub24oXCJwcm9jZXNzaW5nbXVsdGlwbGVcIiwgZnVuY3Rpb24oZWxlbWVudExpc3QpIHtcbiAgICAkKCcudXBsb2FkTGVuZ3RoJykucmVtb3ZlQ2xhc3MoJ2hpZGRlbicpO1xuICAgICQoJy51cGxvYWRMZW5ndGgnKS50ZXh0KGVsZW1lbnRMaXN0Lmxlbmd0aCArICcgRmlsZShzKSBxdWV1ZWQuJyk7XG4gIH0pO1xuXG4gIC8vIGluaXQgY2xpY2sgZXZlbnQgZm9yIGNhbmNlbC1mdW5jIG9uIGJvZHksIGJlY2F1c2UgY2FuY2VsIGJ1dHRvbiBpcyBub3QgbG9hZGVkIGluaXRpYWxseSBkdWUgdG8gcHJldmlldy10ZW1wbGF0ZS1yZW1vdmFsIGF0IHN0YXJ0XG4gICQoJ2JvZHknKS5vbignY2xpY2snLCAnLnVwbG9hZENhbmNlbCcsIGZ1bmN0aW9uICgpIHtcbiAgICBjb3JwdXNVcGxvYWQucmVtb3ZlQWxsRmlsZXModHJ1ZSk7XG4gIH0pO1xufSIsIiQoJy5jbGVhci1zZWFyY2gnKS5vbignY2xpY2snLCBmdW5jdGlvbigpIHtcbiAgJCh0aGlzKS5jbG9zZXN0KCcuaW5wdXQtZ3JvdXAnKS5maW5kKCdpbnB1dCcpLnZhbCgnJylcbn0pOyIsIiQoJy5jb2xsYXBzZScpLm9uKCdzaG93LmJzLmNvbGxhcHNlJywgZnVuY3Rpb24gKCkge1xuICAkKHRoaXMpLnByZXYoKS5jaGlsZHJlbignLmNvbGxhcHNlLWluZGljYXRvcicpLmNzcygndHJhbnNmb3JtJywnaW5pdGlhbCcpO1xufSk7XG4kKCcuY29sbGFwc2UnKS5vbignaGlkZS5icy5jb2xsYXBzZScsIGZ1bmN0aW9uICgpIHtcbiAgJCh0aGlzKS5wcmV2KCkuY2hpbGRyZW4oJy5jb2xsYXBzZS1pbmRpY2F0b3InKS5jc3MoJ3RyYW5zZm9ybScsJ3JvdGF0ZSgxODBkZWcpJyk7XG59KTsiLCJ2YXIgaW5wdXRMaXN0ID0gWycjZm9ybUNvcnB1c0Zvcm1hdHMnLCAnI2Zvcm1Bbm5vdGF0aW9uc0Zvcm1hdHMnXTtcbnZhciBjdXN0b21QbGFjZWhvbGRlcnMgPSBbJ1wiQU5OSVNcIicsJ1wiQU5OSVNcIiddO1xuXG5mb3IodmFyIGggPSAwOyBoIDwgaW5wdXRMaXN0Lmxlbmd0aDsgaCsrKSB7XG4gICQoaW5wdXRMaXN0W2hdKS5mbGV4ZGF0YWxpc3Qoe1xuICAgIG1pbkxlbmd0aDogMFxuICB9KTtcbiAgbGV0IGkgPSBoXG4gICQoaW5wdXRMaXN0W2ldICsgJy1mbGV4ZGF0YWxpc3QnKS5hdHRyKCdwbGFjZWhvbGRlcicsIGN1c3RvbVBsYWNlaG9sZGVyc1tpXSk7XG5cbiAgJChpbnB1dExpc3RbaV0pLm9uKCdjaGFuZ2U6ZmxleGRhdGFsaXN0JywgZnVuY3Rpb24oZXZlbnQsIHNldCwgb3B0aW9ucykge1xuICAgIGlmKCQoaW5wdXRMaXN0W2ldKS5mbGV4ZGF0YWxpc3QoJ3ZhbHVlJykubGVuZ3RoID4gMCkge1xuICAgICAgJChpbnB1dExpc3RbaV0gKyAnLWZsZXhkYXRhbGlzdCcpLmF0dHIoJ3BsYWNlaG9sZGVyJywgJycpO1xuICAgIH0gZWxzZSB7XG4gICAgICAkKGlucHV0TGlzdFtpXSArICctZmxleGRhdGFsaXN0JykuYXR0cigncGxhY2Vob2xkZXInLCBjdXN0b21QbGFjZWhvbGRlcnNbaV0pO1xuICAgIH1cbiAgfSk7XG59IiwiXG4vLyBFRElUIGJ1dHRvbiBpbiBjb3JwdXNQcm9qZWN0IEVkaXRzXG4kKCcuY29ycHVzUHJvamVjdCAuY29ycHVzUHJvamVjdC1zdGFydEVkaXQnKS5jbGljayhmdW5jdGlvbigpIHtcbiAgbGV0IGNvcnB1c1Byb2plY3QgPSAkKHRoaXMpLmNsb3Nlc3QoJy5jb3JwdXNQcm9qZWN0Jyk7XG4gIGNvcnB1c1Byb2plY3QuZmluZCgnLmNvcnB1c1Byb2plY3Qtc2F2ZScpLnRvZ2dsZUNsYXNzKCdoaWRkZW4nKTtcbiAgY29ycHVzUHJvamVjdC5maW5kKCcuY29ycHVzUHJvamVjdC1lZGl0JykudG9nZ2xlQ2xhc3MoJ2hpZGRlbicpO1xuXG4gIGxldCB0aXRsZSA9IGNvcnB1c1Byb2plY3QuZmluZCgnLmNvcnB1c1Byb2plY3QtdGl0bGUnKS50ZXh0KCkudHJpbSgpO1xuICBsZXQgZGVzY3JpcHRpb24gPSBjb3JwdXNQcm9qZWN0LmZpbmQoJy5jb3JwdXNQcm9qZWN0LWRlc2NyaXB0aW9uJykudGV4dCgpLnRyaW0oKTtcblxuICBjb3JwdXNQcm9qZWN0LmZpbmQoJy5jb3JwdXNQcm9qZWN0LWRlc2NyaXB0aW9uLWVkaXQnKS52YWwoZGVzY3JpcHRpb24pO1xuICBjb3JwdXNQcm9qZWN0LmZpbmQoJy5jb3JwdXNQcm9qZWN0LXRpdGxlLWVkaXQnKS52YWwodGl0bGUpO1xufSk7XG5cbi8vIFNBVkUgYnV0dG9uIGluIGNvcnB1c1Byb2plY3QgRWRpdHNcbiQoJy5jb3JwdXNQcm9qZWN0IC5jb3JwdXNQcm9qZWN0LXNhdmVFZGl0JykuY2xpY2soZnVuY3Rpb24oKSB7XG4gIGxldCBjb3JwdXNQcm9qZWN0ID0gJCh0aGlzKS5jbG9zZXN0KCcuY29ycHVzUHJvamVjdCcpO1xuICBjb3JwdXNQcm9qZWN0LmZpbmQoJy5jb3JwdXNQcm9qZWN0LXNhdmUnKS50b2dnbGVDbGFzcygnaGlkZGVuJyk7XG4gIGNvcnB1c1Byb2plY3QuZmluZCgnLmNvcnB1c1Byb2plY3QtZWRpdCcpLnRvZ2dsZUNsYXNzKCdoaWRkZW4nKTtcblxuICAvLyAtLSAtLSAtLSAtLVxuICAvLyBIZXJlIHlvdSBjYW4gc3VibWl0IHRoZSBjaGFuZ2VzIHRvIHRoZSBmb3JtIHRvIHRoZSBiYWNrZW5kIG9mIHdoYXRldmVyXG4gIC8vIC0tIC0tIC0tIC0tXG59KTtcblxuLy8gQ0FOQ0VMIGJ1dHRvbiBpbiBjb3JwdXNQcm9qZWN0IEVkaXRzXG4kKCcuY29ycHVzUHJvamVjdCAuY29ycHVzUHJvamVjdC1lbmRFZGl0JykuY2xpY2soZnVuY3Rpb24oKSB7XG4gIGxldCBjb3JwdXNQcm9qZWN0ID0gJCh0aGlzKS5jbG9zZXN0KCcuY29ycHVzUHJvamVjdCcpO1xuICBjb3JwdXNQcm9qZWN0LmZpbmQoJy5jb3JwdXNQcm9qZWN0LXNhdmUnKS50b2dnbGVDbGFzcygnaGlkZGVuJyk7XG4gIGNvcnB1c1Byb2plY3QuZmluZCgnLmNvcnB1c1Byb2plY3QtZWRpdCcpLnRvZ2dsZUNsYXNzKCdoaWRkZW4nKTtcbn0pOyIsIiQoZnVuY3Rpb24gKCkge1xuICAkKCdbZGF0YS10b2dnbGU9XCJ0b29sdGlwXCJdJykudG9vbHRpcCgpXG59KSIsIiQoZG9jdW1lbnQpLnJlYWR5KCgpID0+IHtcblxuICAvLyBpbml0aWFsaXplIHVuc2xpZGVyLWNhcm91c2VsIGZvciB0aGUgc2xpZGVzIG9uIHRoZSBob21lIHBhZ2VcbiAgJCgnLmhvbWVDYXJvdXNlbCcpLnVuc2xpZGVyKHtcbiAgICBpbmZpbml0ZTogdHJ1ZSxcbiAgICBhcnJvd3M6IHtcbiAgICAgIHByZXY6ICc8YSBjbGFzcz1cInVuc2xpZGVyLWFycm93IHByZXZcIj48aSBjbGFzcz1cImZhIGZhLTJ4IGZhLWFuZ2xlLWxlZnQgdGV4dC13aW5lLXRyYW5zXCI+PC9pPjwvYT4nLFxuICAgICAgbmV4dDogJzxhIGNsYXNzPVwidW5zbGlkZXItYXJyb3cgbmV4dFwiPjxpIGNsYXNzPVwiZmEgZmEtMnggZmEtYW5nbGUtcmlnaHQgdGV4dC13aW5lLXRyYW5zXCI+PC9pPjwvYT4nLFxuICAgIH1cbiAgfSk7XG5cbiAgLy8gYWZ0ZXIgY2Fyb3VzZWwgaW5pdGlhbGl6YXRpb24sIG1hdGNoIHRoZSBoZWlnaHQgb2YgdGhlIHR3byBib3hlcyBvbiBob21lIHBhZ2UgKGZsZXhib3ggZHVlIHRvIGNvbC1yb3ctZ3JpZCBub3QgdXNhYmxlKVxuICAkKGZ1bmN0aW9uKCkge1xuICAgICQoJy5tYXRjaGVkSGVpZ2h0JykubWF0Y2hIZWlnaHQoKTtcbiAgfSk7XG59KTsiLCJjb25zdCBzdWdnZXN0aW9ucyA9IFtcbiAge1xuICAgIFwidmFsdWVcIjogXCJDdXJyeVwiLFxuICAgIFwiZGF0YVwiOiBcIk5vcmVlblwiXG4gIH0sXG4gIHtcbiAgICBcInZhbHVlXCI6IFwiU2FuZGVyc1wiLFxuICAgIFwiZGF0YVwiOiBcIkhvZ2FuXCJcbiAgfSxcbiAge1xuICAgIFwidmFsdWVcIjogXCJDaGVycnlcIixcbiAgICBcImRhdGFcIjogXCJBbHRoZWFcIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIkFseWNlXCIsXG4gICAgXCJkYXRhXCI6IFwiQWRlbGFcIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIkRhdmlkc29uXCIsXG4gICAgXCJkYXRhXCI6IFwiTWlzdHlcIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIkRvcm90aGVhXCIsXG4gICAgXCJkYXRhXCI6IFwiQ29ybmVsaWFcIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIk1hdGhpc1wiLFxuICAgIFwiZGF0YVwiOiBcIlN0ZWluXCJcbiAgfSxcbiAge1xuICAgIFwidmFsdWVcIjogXCJNYXJzaFwiLFxuICAgIFwiZGF0YVwiOiBcIkV2ZVwiXG4gIH0sXG4gIHtcbiAgICBcInZhbHVlXCI6IFwiRGFuaWVsbGVcIixcbiAgICBcImRhdGFcIjogXCJNY2ZhcmxhbmRcIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIkRlc2lyZWVcIixcbiAgICBcImRhdGFcIjogXCJQYWNoZWNvXCJcbiAgfSxcbiAge1xuICAgIFwidmFsdWVcIjogXCJLbm94XCIsXG4gICAgXCJkYXRhXCI6IFwiR3VlcnJlcm9cIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIk15cmFcIixcbiAgICBcImRhdGFcIjogXCJCZXJ0YVwiXG4gIH0sXG4gIHtcbiAgICBcInZhbHVlXCI6IFwiS2VsbGllXCIsXG4gICAgXCJkYXRhXCI6IFwiR3JldGNoZW5cIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIkplYW5ldHRlXCIsXG4gICAgXCJkYXRhXCI6IFwiQW5kcmVhXCJcbiAgfSxcbiAge1xuICAgIFwidmFsdWVcIjogXCJXb3JrbWFuXCIsXG4gICAgXCJkYXRhXCI6IFwiQmFsbGFyZFwiXG4gIH0sXG4gIHtcbiAgICBcInZhbHVlXCI6IFwiTW9yYW5cIixcbiAgICBcImRhdGFcIjogXCJSZWJla2FoXCJcbiAgfSxcbiAge1xuICAgIFwidmFsdWVcIjogXCJBbGFuYVwiLFxuICAgIFwiZGF0YVwiOiBcIkxlYW5uZVwiXG4gIH0sXG4gIHtcbiAgICBcInZhbHVlXCI6IFwiU3VhcmV6XCIsXG4gICAgXCJkYXRhXCI6IFwiQ29uY2V0dGFcIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIkZlbGVjaWFcIixcbiAgICBcImRhdGFcIjogXCJaYW1vcmFcIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIkZsb3dlcnNcIixcbiAgICBcImRhdGFcIjogXCJOb2VsXCJcbiAgfSxcbiAge1xuICAgIFwidmFsdWVcIjogXCJUaG9ybnRvblwiLFxuICAgIFwiZGF0YVwiOiBcIkNvbGV0dGVcIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIlN1c2FubmFcIixcbiAgICBcImRhdGFcIjogXCJSb3lcIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIkhhdGZpZWxkXCIsXG4gICAgXCJkYXRhXCI6IFwiU2tpbm5lclwiXG4gIH0sXG4gIHtcbiAgICBcInZhbHVlXCI6IFwiQmxhbmtlbnNoaXBcIixcbiAgICBcImRhdGFcIjogXCJGaXNoZXJcIlxuICB9LFxuICB7XG4gICAgXCJ2YWx1ZVwiOiBcIk1pdGNoZWxsXCIsXG4gICAgXCJkYXRhXCI6IFwiQnJ5YW5cIlxuICB9XG5dXG5cbi8vIEluaXRpYWxpemUgYXV0b2NvbXBsZXRpb24gZm9yIGV2ZXJ5IGZpbHRlciBmb3JtIGlucHV0XG5cbiQoJyNmb3JtQ29ycHVzVGl0bGUnKS5hdXRvY29tcGxldGUoe1xuICBsb29rdXA6IHN1Z2dlc3Rpb25zXG59KTtcbiQoJyNmb3JtQ29ycHVzTGFuZ3VhZ2UnKS5hdXRvY29tcGxldGUoe1xuICBsb29rdXA6IHN1Z2dlc3Rpb25zXG59KTtcbiQoJyNmb3JtQ29ycHVzUHVibGlzaGVyJykuYXV0b2NvbXBsZXRlKHtcbiAgbG9va3VwOiBzdWdnZXN0aW9uc1xufSk7XG4kKCcjZm9ybUNvcnB1c0xpY2Vuc2VzJykuYXV0b2NvbXBsZXRlKHtcbiAgbG9va3VwOiBzdWdnZXN0aW9uc1xufSk7XG5cblxuJCgnI2Zvcm1Eb2N1bWVudHNUaXRsZScpLmF1dG9jb21wbGV0ZSh7XG4gIGxvb2t1cDogc3VnZ2VzdGlvbnNcbn0pO1xuJCgnI2Zvcm1Eb2N1bWVudHNBdXRob3InKS5hdXRvY29tcGxldGUoe1xuICBsb29rdXA6IHN1Z2dlc3Rpb25zXG59KTtcbiQoJyNmb3JtRG9jdW1lbnRzTGFuZ3VhZ2UnKS5hdXRvY29tcGxldGUoe1xuICBsb29rdXA6IHN1Z2dlc3Rpb25zXG59KTtcbiQoJyNmb3JtRG9jdW1lbnRzUGxhY2UnKS5hdXRvY29tcGxldGUoe1xuICBsb29rdXA6IHN1Z2dlc3Rpb25zXG59KTtcblxuXG4kKCcjZm9ybUFubm90YXRpb25zVGl0bGUnKS5hdXRvY29tcGxldGUoe1xuICBsb29rdXA6IHN1Z2dlc3Rpb25zXG59KTtcbiQoJyNmb3JtQW5ub3RhdGlvbnNMYW5ndWFnZScpLmF1dG9jb21wbGV0ZSh7XG4gIGxvb2t1cDogc3VnZ2VzdGlvbnNcbn0pO1xuIiwiLy8gZmlsZVVwbG9hZCBsaWJyYXJ5IFwiRHJvcHpvbmVKU1wiXG4vLyBEb2N1bWVudGF0aW9uOiBodHRwOi8vd3d3LmRyb3B6b25lanMuY29tL1xuXG5mdW5jdGlvbiB0b2dnbGVWaWV3VXBsb2FkKCkge1xuICAgIC8vIGhpZGUgZW50ZXItdXBsb2FkIGJ1dHRvblxuICAgICQoJy5lbnRlckxvZ29VcGxvYWQnKS50b2dnbGVDbGFzcygnaGlkZGVuJyk7XG4gICAgLy8gc2hvdyBsZWF2ZS11cGxvYWQgYnV0dG9uXG4gICAgJCgnLmxlYXZlTG9nb1VwbG9hZCcpLnRvZ2dsZUNsYXNzKCdoaWRkZW4nKTtcbiAgICAvLyBoaWRlIHVwbG9hZCBhcmVhXG4gICAgJCgnLnVwbG9hZEFyZWEnKS50b2dnbGVDbGFzcygnaGlkZGVuJyk7XG4gICAgLy8gc2hvdyB1cGxvYWQgcGxhY2Vob2xkZXJcbiAgICAkKCcudXBsb2FkUGxhY2Vob2xkZXInKS50b2dnbGVDbGFzcygnaGlkZGVuJyk7XG59XG5cbmZ1bmN0aW9uIHRvZ2dsZVVwbG9hZFN0YXR1cygpIHtcbiAgICAvLyBkaXNwbGF5IHRoZSBwcmV2aWV3IGFuZCBwcm9ncmVzcyB0aGluZ3NcbiAgICAkKCcubG9nb1VwbG9hZC1lbmQnKS50b2dnbGVDbGFzcygnaGlkZGVuJyk7XG4gICAgLy8gaGlkZSB0aGUgZGVmYXVsdCB2aWV3XG4gICAgJCgnLmxvZ29VcGxvYWQtc3RhcnQnKS50b2dnbGVDbGFzcygnaGlkZGVuJyk7XG59XG5cbi8vIHByZXZlbnQgZG91YmxlIGRyb3B6b25lc1xuRHJvcHpvbmUuYXV0b0Rpc2NvdmVyID0gZmFsc2U7XG5cbnZhciBwcmV2aWV3Tm9kZSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoXCIjdGVtcGxhdGVcIik7XG5pZihwcmV2aWV3Tm9kZSkge1xuXG4gIC8vIGNoYW5nZSB2aWV3IGZyb20gY2FuY2VsIHRvIHVwbG9hZFxuICAkKCcuZW50ZXJMb2dvVXBsb2FkJykuY2xpY2soKCkgPT4ge1xuICAgIHRvZ2dsZVZpZXdVcGxvYWQoKTtcbiAgfSk7XG5cbiAgLy8gY2hhbmdlIHZpZXcgZnJvbSB1cGxvYWQgdG8gY2FuY2VsXG4gICQoJy5sZWF2ZUxvZ29VcGxvYWQnKS5jbGljaygoKSA9PiB7XG4gICAgdG9nZ2xlVmlld1VwbG9hZCgpO1xuICB9KTtcblxuICAvLyBzZWUgRG9jdW1lbnRhdGlvbjogaHR0cDovL3d3dy5kcm9wem9uZWpzLmNvbS9cbiAgcHJldmlld05vZGUuaWQgPSBcIlwiO1xuICB2YXIgcHJldmlld1RlbXBsYXRlID0gcHJldmlld05vZGUucGFyZW50Tm9kZS5pbm5lckhUTUw7XG4gIHByZXZpZXdOb2RlLnBhcmVudE5vZGUucmVtb3ZlQ2hpbGQocHJldmlld05vZGUpO1xuXG4gIC8vIGluaXQgZHJvcHpvbmVKU1xuICB2YXIgbG9nb1VwbG9hZCA9IG5ldyBEcm9wem9uZShkb2N1bWVudC5ib2R5LCB7IC8vIE1ha2UgdGhlIHdob2xlIGJvZHkgYSBkcm9wem9uZVxuICAgIHVybDogXCJodHRwOi8vbG9jYWxob3N0OjM1MDBcIiwgLy8gU2V0IHRoZSB1cmxcbiAgICBwYXJhbGxlbFVwbG9hZHM6IDIwLFxuICAgIG1heEZpbGVzOiAxLFxuICAgIHByZXZpZXdUZW1wbGF0ZTogcHJldmlld1RlbXBsYXRlLFxuICAgIGF1dG9RdWV1ZTogdHJ1ZSwgLy8gTWFrZSBzdXJlIHRoZSBmaWxlcyBhcmVuJ3QgcXVldWVkIHVudGlsIG1hbnVhbGx5IGFkZGVkXG4gICAgcHJldmlld3NDb250YWluZXI6IFwiI3ByZXZpZXdzXCIsIC8vIERlZmluZSB0aGUgY29udGFpbmVyIHRvIGRpc3BsYXkgdGhlIHByZXZpZXdzXG4gICAgY2xpY2thYmxlOiAnLnVwbG9hZEFyZWEnIC8vIERlZmluZSB0aGUgZWxlbWVudCB0aGF0IHNob3VsZCBiZSB1c2VkIGFzIGNsaWNrIHRyaWdnZXIgdG8gc2VsZWN0IGZpbGVzLlxuICB9KTtcblxuICAvLyBEcm9wem9uZUpTIGV2ZW50IG1ldGhvZHNcbiAgbG9nb1VwbG9hZC5vbihcImFkZGVkZmlsZVwiLCBmdW5jdGlvbihmaWxlKSB7XG4gICAgdG9nZ2xlVXBsb2FkU3RhdHVzKCk7XG4gIH0pO1xuXG4gIGxvZ29VcGxvYWQub24oXCJzdWNjZXNzXCIsIGZ1bmN0aW9uKGV2ZW50LCByZXNwb25zZSkge1xuICAgIC8vIGRpc3BsYXkgdGh1bWJuYWlsLCBoaWRlIHByb2dyZXNzIGJhciwgZGlzcGxheSBvdGhlciBiYnV0dG9ucywgaGlkZSBwcmV2aW91cyBidXR0b25zXG4gICAgJCgnLnVwbG9hZFRodW1ibmFpbCcpLnRvZ2dsZUNsYXNzKCdoaWRkZW4nKTtcbiAgICAkKCcudXBsb2FkUHJvZ3Jlc3MnKS50b2dnbGVDbGFzcygnaGlkZGVuJyk7XG4gICAgJChcIi5sb2dvVXBsb2FkLWRlbGV0ZVwiKS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgIHRvZ2dsZVVwbG9hZFN0YXR1cygpO1xuICAgICAgbG9nb1VwbG9hZC5yZW1vdmVBbGxGaWxlcyh0cnVlKTtcbiAgICB9KTtcbiAgfSk7XG5cbiAgLy8gdHJpZ2dlciB0aGUgZmlsZSBwaWNrZXIgb24gYnRuIGNsaWNrIHZpYSBoaWRkZW4gaW5wdXQgZmllbGRcbiAgJCgnYm9keScpLm9uKCdjbGljaycsICcudXBsb2FkQnV0dG9uJywgZnVuY3Rpb24gKCkge1xuICAgIGxvZ29VcGxvYWQuaGlkZGVuRmlsZUlucHV0LmNsaWNrKCk7XG4gICAgbG9nb1VwbG9hZC5yZW1vdmVBbGxGaWxlcygpO1xuICAgIHRvZ2dsZVVwbG9hZFN0YXR1cygpO1xuICB9KTtcbn0iLCIvLyBBZnRlciBET00gaXMgcmVhZHkgLi4uXG4kKGRvY3VtZW50KS5yZWFkeSgoKSA9PiB7XG5cbiAgLy8gdmFsaWRhdGUgYWxsIHRleHQgaW5wdXRzIGluIGNvcnJlc3BvbmRpbmcgZm9ybSwgaWYgdGhleSBhcmUgZW1wdHkuIElmIG5vdCwgYWN0aXZhdGUgc3VibWl0IGJ1dHRvblxuICAkKCdpbnB1dC50b0JlVmFsaWRhdGVkJykuYmx1cihmdW5jdGlvbigpe1xuICAgIGxldCBwYXJlbnRGb3JtID0gJCh0aGlzKS5jbG9zZXN0KCdmb3JtJylcbiAgICBsZXQgc3VibWl0QnRuID0gJChwYXJlbnRGb3JtKS5maW5kKCcudG9DaGVja1ZhbGlkYXRpb24nKVxuXG4gICAgbGV0IGVtcHR5RmllbGRzID0gJChwYXJlbnRGb3JtKS5maW5kKCdpbnB1dC50b0JlVmFsaWRhdGVkJykuZmlsdGVyKGZ1bmN0aW9uKCkge1xuICAgICAgcmV0dXJuICQudHJpbSh0aGlzLnZhbHVlKSA9PT0gXCJcIjtcbiAgICB9KTtcblxuICAgIGlmKGVtcHR5RmllbGRzLmxlbmd0aCA+IDApIHtcbiAgICAgIGlmKCEkKHN1Ym1pdEJ0bikuaGFzQ2xhc3MoJ2Rpc2FibGVkJykpIHtcbiAgICAgICAgJChzdWJtaXRCdG4pLmFkZENsYXNzKCdkaXNhYmxlZCcpXG4gICAgICB9XG4gICAgfSBlbHNlIHtcbiAgICAgICQoc3VibWl0QnRuKS5yZW1vdmVDbGFzcygnZGlzYWJsZWQnKVxuICAgIH1cbiAgfSk7XG5cblxuICAvLyB2YWxpZGF0ZSBhbGwgY2hlY2tib3ggaW5wdXRzIGluIGNvcnJlc3BvbmRpbmcgZm9ybSwgaWYgdGhleSBhcmUgY2hlY2tlZC4gSWYsIGFjdGl2YXRlIHN1Ym1pdCBidXR0b25cbiAgJCgnaW5wdXQudG9CZVZhbGlkYXRlZC1jaGVja2JveCcpLmNoYW5nZShmdW5jdGlvbigpe1xuICAgIGxldCBwYXJlbnRGb3JtID0gJCh0aGlzKS5jbG9zZXN0KCdmb3JtJylcbiAgICBsZXQgc3VibWl0QnRuID0gJChwYXJlbnRGb3JtKS5maW5kKCcudG9DaGVja1ZhbGlkYXRpb24nKVxuXG4gICAgbGV0IHVuY2hlY2tlZEJveGVzID0gJChwYXJlbnRGb3JtKS5maW5kKCdpbnB1dC50b0JlVmFsaWRhdGVkLWNoZWNrYm94Om5vdCg6Y2hlY2tlZCknKVxuXG4gICAgaWYodW5jaGVja2VkQm94ZXMubGVuZ3RoID4gMCkge1xuICAgICAgaWYoISQoc3VibWl0QnRuKS5oYXNDbGFzcygnZGlzYWJsZWQnKSkge1xuICAgICAgICAkKHN1Ym1pdEJ0bikuYWRkQ2xhc3MoJ2Rpc2FibGVkJylcbiAgICAgIH1cbiAgICB9IGVsc2Uge1xuICAgICAgJChzdWJtaXRCdG4pLnJlbW92ZUNsYXNzKCdkaXNhYmxlZCcpXG4gICAgfVxuICB9KTtcblxuXG4gIC8vIEJ1dHRvbiBWYWxpZGF0aW9uIGZvciBBZG1pbiAtIFB1Ymxpc2ggLSBUYWJsZXMgLS0gU2VsZWN0L0RlbGV0ZSBBbGxcbiAgJCgnLmRvY3VtZW50cy10YWJsZSBpbnB1dDpjaGVja2JveCcpLmNoYW5nZShmdW5jdGlvbigpe1xuICAgIGlmKCQoJy5kb2N1bWVudHMtdGFibGUgdGJvZHkgaW5wdXQ6Y2hlY2tib3g6Y2hlY2tlZCcpLmxlbmd0aCA+IDApIHtcbiAgICAgICAgJCgnLmRvY3VtZW50cy10YWJsZSB0Zm9vdCBidXR0b24nKS5yZW1vdmVDbGFzcygnZGlzYWJsZWQnKTtcbiAgICB9IGVsc2Uge1xuICAgICAgICAkKCcuZG9jdW1lbnRzLXRhYmxlIHRmb290IGJ1dHRvbicpLmFkZENsYXNzKCdkaXNhYmxlZCcpO1xuICAgIH1cbiAgfSk7XG5cblxuICAvLyBBZG1pbiAtIFB1Ymxpc2ggLSBNb2RhbCB2YWxpZGF0ZSBpZiBhbGwgY2hlY2tzIGFyZSBwYXNzZWRcbiAgLy8gJCgnI3B1Ymxpc2hDb3JwdXNNb2RhbCAuLi5FTEVNRU5UU19UT19URVNUX09OLi4uJykuY2hhbmdlKGZ1bmN0aW9uKCkge1xuICAvLyAgIC8vIGhlcmUgZ29lcyB5b3VyIGNvZGUgZm9yIGRlY2lkaW5nIHdoZXRoZXIgdG8gYWN0aXZhdGUgdGhlIFwicHVibGlzaFwiLWJ1dHRvbiBvciBub3RcblxuICAvLyAgIC8vIGFjdGl2YXRlIHRoZSBcInB1Ymxpc2hcIi1idXR0b25cbiAgLy8gICAkKCcjcHVibGlzaENvcnB1c01vZGFsIG1vZGFsLWZvb3RlciBidXR0b24nKS5yZW1vdmVDbGFzcygnZGlzYWJsZWQnKTtcbiAgLy8gfSk7XG5cblxuICAvLyBBZG1pbiAtIFB1Ymxpc2ggLSBQcmV2aWV3IHZhbGlkYXRpb25cbiAgLy8gSGVyZSB5b3Ugc2hvdWxkIGRlZmluZSB5b3VyIG93biBydWxlcywgd2hldGhlciB0byBhY3RpdmF0ZSB0aGUgXCJwcmV2aWV3XCItYnV0dG9uXG4gIC8vIHRoZSBlbGVtZW50IHRvIGNoYW5nZTpcbiAgLy8gJCgnI2NvcnB1c01haW5BY3Rpb25zIC5jb3JwdXNQcmV2aWV3JykucmVtb3ZlQ2xhc3MoJ2Rpc2FibGVkJyk7XG5cbn0pOyIsInZhciByYW5nZVNsaWRlckxpc3QgPSBbJ2NvcnB1c1NpemUnLCdkb2N1bWVudFNpemUnXVxuXG5mb3IodmFyIGggPSAwOyBoIDwgcmFuZ2VTbGlkZXJMaXN0Lmxlbmd0aDsgaCsrKSB7XG5cdGxldCBpID0gaFxuXG5cdGxldCBlbCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKHJhbmdlU2xpZGVyTGlzdFtpXSlcblx0aWYoZWwpIHtcblx0XHRlbC5zdHlsZS5oZWlnaHQgPSAnOHB4Jztcblx0XHRlbC5zdHlsZS5tYXJnaW4gPSAnMCBhdXRvIDhweCc7XG5cblx0XHRub1VpU2xpZGVyLmNyZWF0ZShlbCwge1xuXHRcdFx0YW5pbWF0ZTogdHJ1ZSxcblx0XHRcdHN0YXJ0OiBbIDEsIDk5OTk5OSBdLCAvLyA0IGhhbmRsZXMsIHN0YXJ0aW5nIGF0Li4uXG5cdFx0XHRtYXJnaW46IDEsIC8vIEhhbmRsZXMgbXVzdCBiZSBhdCBsZWFzdCAzMDAgYXBhcnRcblx0XHRcdGxpbWl0OiA5OTk5OTgsIC8vIC4uLiBidXQgbm8gbW9yZSB0aGFuIDYwMFxuXHRcdFx0Y29ubmVjdDogdHJ1ZSwgLy8gRGlzcGxheSBhIGNvbG9yZWQgYmFyIGJldHdlZW4gdGhlIGhhbmRsZXNcblx0XHRcdG9yaWVudGF0aW9uOiAnaG9yaXpvbnRhbCcsIC8vIE9yaWVudCB0aGUgc2xpZGVyIHZlcnRpY2FsbHlcblx0XHRcdGJlaGF2aW91cjogJ3RhcC1kcmFnJywgLy8gTW92ZSBoYW5kbGUgb24gdGFwLCBiYXIgaXMgZHJhZ2dhYmxlXG5cdFx0XHRzdGVwOiAxLFxuXG5cdFx0XHRyYW5nZToge1xuXHRcdFx0XHQnbWluJzogMSxcblx0XHRcdFx0J21heCc6IDk5OTk5OVxuXHRcdFx0fSxcblx0XHR9KTtcblxuXHRcdGxldCBwYWRkaW5nTWluID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQocmFuZ2VTbGlkZXJMaXN0W2ldICsgJy1taW5WYWwnKSxcblx0XHRcdFx0cGFkZGluZ01heCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKHJhbmdlU2xpZGVyTGlzdFtpXSArICctbWF4VmFsJyk7XG5cblx0XHRlbC5ub1VpU2xpZGVyLm9uKCd1cGRhdGUnLCBmdW5jdGlvbiAoIHZhbHVlcywgaGFuZGxlICkge1xuXHRcdFx0aWYgKCBoYW5kbGUgKSB7XG5cdFx0XHRcdHBhZGRpbmdNYXguaW5uZXJIVE1MID0gTWF0aC5yb3VuZCh2YWx1ZXNbaGFuZGxlXSk7XG5cdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRwYWRkaW5nTWluLmlubmVySFRNTCA9IE1hdGgucm91bmQodmFsdWVzW2hhbmRsZV0pO1xuXHRcdFx0fVxuXHRcdH0pO1xuXG5cdFx0ZWwubm9VaVNsaWRlci5vbignY2hhbmdlJywgZnVuY3Rpb24oKXtcblx0XHRcdC8vIFZhbGlkYXRlIGNvcnJlc3BvbmRpbmcgZm9ybVxuXHRcdFx0bGV0IHBhcmVudEZvcm0gPSAkKGVsKS5jbG9zZXN0KCdmb3JtJylcblx0XHRcdCQocGFyZW50Rm9ybSkuZmluZCgnKlt0eXBlPXN1Ym1pdF0nKS5yZW1vdmVDbGFzcygnZGlzYWJsZWQnKTtcblx0XHR9KTtcblx0fVxufSIsIiQoJyN0b1RvcCcpLm9uKFwiY2xpY2tcIiwgZnVuY3Rpb24oZXZlbnQpIHtcbiAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcbiAgY29uc29sZS5sb2coJ2pvJylcbiAgJChcImh0bWwsIGJvZHlcIikuYW5pbWF0ZShcbiAgICB7XG4gICAgICBzY3JvbGxUb3A6ICQoJyNyb290Q29udGFpbmVyJykub2Zmc2V0KCkudG9wXG4gICAgfSxcbiAgICA1MDBcbiAgKTtcbn0pO1xuIiwiJCgnI3NlbGVjdEFsbF9jb3JwdXNFZGl0JykuY2xpY2soZnVuY3Rpb24gKGUpIHtcbiAgICAkKHRoaXMpLmNsb3Nlc3QoJ3RhYmxlJykuZmluZCgndGQgaW5wdXQ6Y2hlY2tib3gnKS5wcm9wKCdjaGVja2VkJywgdGhpcy5jaGVja2VkKTtcbn0pOyJdfQ==