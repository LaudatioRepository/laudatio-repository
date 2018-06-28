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

    // init dropzoneJS
    var corpusUpload = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "http://localhost:3500", // Set the url
        parallelUploads: 20,
        uploadMultiple: true,
        previewTemplate: previewTemplate,
        autoQueue: true, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: '.uploadArea' // Define the element that should be used as click trigger to select files.
    });

    // DropzoneJS event methods
    corpusUpload.on("processing", function(file) {
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

    corpusUpload.on("error", function(file) {
        $(file.previewElement).find('.uploadStatusText').text('');
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

var previewNode = document.querySelector("#template");
if(previewNode) {

    // change view from cancel to upload
    $('.enterLogoUpload').click(() => {
        toggleViewUpload();
    });

    // change view from upload to cancel
    $('.leaveLogoUpload').click(() => {
        toggleViewUpload();
    });

    // see Documentation: http://www.dropzonejs.com/
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    // init dropzoneJS
    var logoUpload = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "http://localhost:3500", // Set the url
        parallelUploads: 20,
        maxFiles: 1,
        previewTemplate: previewTemplate,
        autoQueue: true, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: '.uploadArea' // Define the element that should be used as click trigger to select files.
    });

    // DropzoneJS event methods
    logoUpload.on("addedfile", function(file) {
        toggleUploadStatus();
    });

    logoUpload.on("success", function(event, response) {
        // display thumbnail, hide progress bar, display other bbuttons, hide previous buttons
        $('.uploadThumbnail').toggleClass('hidden');
        $('.uploadProgress').toggleClass('hidden');
        $(".logoUpload-delete").click(function() {
            toggleUploadStatus();
            logoUpload.removeAllFiles(true);
        });
    });

    // trigger the file picker on btn click via hidden input field
    $('body').on('click', '.uploadButton', function () {
        logoUpload.hiddenFileInput.click();
        logoUpload.removeAllFiles();
        toggleUploadStatus();
    });
}
var rangeSliderList = ['corpusSize','documentSize']

for(var h = 0; h < rangeSliderList.length; h++) {
    let i = h

    let el = document.getElementById(rangeSliderList[i])
    if(el) {
        el.style.height = '8px';
        el.style.margin = '0 auto 8px';

        noUiSlider.create(el, {
            animate: true,
            start: [ 1, 999999 ], // 4 handles, starting at...
            margin: 1, // Handles must be at least 300 apart
            limit: 999998, // ... but no more than 600
            connect: true, // Display a colored bar between the handles
            orientation: 'horizontal', // Orient the slider vertically
            behaviour: 'tap-drag', // Move handle on tap, bar is draggable
            step: 1,

            range: {
                'min': 1,
                'max': 999999
            },
        });

        let paddingMin = document.getElementById(rangeSliderList[i] + '-minVal'),
            paddingMax = document.getElementById(rangeSliderList[i] + '-maxVal');

        el.noUiSlider.on('update', function ( values, handle ) {
            if ( handle ) {
                paddingMax.innerHTML = Math.round(values[handle]);
            } else {
                paddingMin.innerHTML = Math.round(values[handle]);
            }
        });

        el.noUiSlider.on('change', function(){
            // Validate corresponding form
            let parentForm = $(el).closest('form')
            $(parentForm).find('*[type=submit]').removeClass('disabled');
        });
    }
}
$('#toTop').on("click", function(event) {
    event.preventDefault();
    console.log('joffd')
    $("html, body").animate(
        {
            scrollTop: $('#browseapp').offset().top
        },
        500
    );
});

$('#selectAll_corpusEdit').click(function (e) {
    $(this).closest('table').find('td input:checkbox').prop('checked', this.checked);
});