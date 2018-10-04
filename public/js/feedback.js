//jq191 is used for a noConflict (instead of $)
jq191(document).ready(function() {
    jq191("#sc_feedback").html(' \
    <script src="/sitecomments/sc_jquery-ui-1.10.3.custom.js"></script> \
    <script src="/sitecomments/sc_action.js"></script> \
    <script src="/sitecomments/sc_paging.js"></script> \
    <link rel="stylesheet" href="/sitecomments/jquery-ui-1.10.3.custom.css"/> \
    <div class="sc_showPreview" id="sc_showPreview" style="display:none" title="Vorschau">\
        <div class="sc_previewWrapper" id="sc_previewWrapper"> \
            <input class="sc_usernamePreview" id="sc_usernamePreview"></input><br/>\
            <input class="sc_titlePreview" id="sc_titlePreview"></input><br/>\
            <textarea class="sc_BodyPreview" id="sc_BodyPreview"></textarea>\
        </div>\
        <div> \
            <img class="sc_captcha" id="sc_captcha" src="https://www3.hu-berlin.de/sitecomments/frontend/securimage/securimage_show.php" alt="CAPTCHA Image" /> \
            <input class="captcha_code" name="captcha_code" id="captcha_code" type="text" size="10" maxlength="6" /> \
            <a class="sc_a sc_showDiffImage" id="cs_showDiffImage" href="#" onclick="showDiffImage()">[ ein anderes Bild anzeigen ]</a> \
        </div>\
        <input class="currentURL" id="currentURL" name="currentURL" type="hidden"/> \
    </div>\
    <a class="sc_a registerSiteLink" id="registerSiteLink" href="/sitecomments/" style="display:none">Seite registrieren</a> \
    <div class="sc_feedbackForm" id="sc_feedbackForm"> \
        <table id="sc_addCommentFields" style="display:none;"> \
            <tr><td><input class="sc_addUsername" name="sc_addUsername" id="sc_addUsername" type="text"  placeholder="Name" /> \
                    <input class="sc_addEmail" name="sc_addEmail" id="sc_addEmail" type="text" placeholder="E-Mail" /></td></tr> \
            <tr><td><input class="sc_addTitle" name="sc_addTitle" id="sc_addTitle" type="text" placeholder="Betreff" /></td></tr> \
            <tr><td> \
                    <textarea class="sc_addBody" name="sc_addBody" id="sc_addBody" placeholder="Kommentar"></textarea><span class="sc_requiredLable">*</span> \
                </td> \
            </tr> \
            <tr><td><input class="sc_sendComment" id="sc_sendComment" value="Senden" type="submit" onclick="showPreview()"/> \
                    <input class="sc_stopSendComment" id="sc_stopSendComment" value="Abbrechen" type="submit" onclick="hideAddCommentFields()"/> \
            </td></tr> \
        </table> \
    </div> \
    <a class="sc_a sc_showAddCommentFields" id="sc_showAddCommentFields" onclick="showAddCommentFields();"></a> \
    <div id="sc_pagingLengthWrapper"><select class="sc_pagingLength" id="sc_pagingLength" onchange="pagingLength()">\
    <option>2</option><option id="sc_pagingLength5">5</option><option id="sc_pagingLength10">10</option><option id="sc_pagingLength20">20</option><option id="sc_pagingLength50">50</option><option>alle</option></select>\
    <span id="sc_pagingLengthLabel">Kommentare anzeigen</span></div>\
    <div class="sc_printComments" id="sc_printComments"></div>\
    <div class="sc_pagingControls" id="sc_pagingControls"></div> \
    <script> \
        var curURL = document.URL;   \
        jq191.ajax({type:"POST",url:"https://www3.hu-berlin.de/sitecomments/frontend/print_comments.php",data:{curURL: curURL,}}).done(function(data){jq191("#sc_printComments").html(data);pagingCall(2,3);setStrings();}); \
        document.getElementById(\'currentURL\').value = document.URL;  \
        jq191("#sc_feedbackBanner").click(function() {\
            jq191("html, body").animate({\
                scrollTop: jq191("#sc_feedback").offset().top\
            }, 2000);\
        }); \
        var sc_userLang = jq191("html").attr("lang"); \
    </script> \
    <script src="/sitecomments/sc_strings.js"></script> \
    ');
});