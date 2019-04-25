<?php
/**
 * Event Add form
 * User: Frank Théodoloz
 * Date: 18.10.2018
 * Time: 11:13
 */

include_once('header.php');
include_once('../model/calendar_model.php');

//get the current language of this element
$languageId = $_COOKIE['elementLanguage'];

?>

<div class="container mt-5">
    <div class="row">
        <div class="col col-lg-6 col-md-8 col-12 cf1 centered">

            <div class="pageTitle"><?= $lang['event_add'] ?></div>
            <a href="../view/calendar.php"><?= $lang['calendar_back'] ?></a>

            <!--it's the select to manage the languages of the element warning: the id must be different from siteLanguage-->
            <input class="cf1" type="hidden" name="languageId" value="<?= $_COOKIE['siteLanguage'] ?>">
            <select id="elementLanguage" name="languageId" style="float:right">
                <!--the options are filled up by a js function-->
            </select>

            <form class="cf1" method="post" action="../controller/event_controller.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="eventAdd"/>
                <input type="hidden" name="languageId" value="<?= $languageId ?>"/>

                <input type="text" name="eventTitle" placeholder="<?= $lang['event_name'] ?>"
                       value="" autofocus required/><br/>
                <input type="text" name="eventAddress" placeholder="<?= $lang['address'] ?>"
                       value="" autofocus required/><br/>

                <input type="text" class="datetimepicker-input" id="datetimepickerStart" name="eventStartDate"
                       data-toggle="datetimepicker" data-target="#datetimepickerStart" placeholder="<?= $lang['start_date'] ?>" required/>
                <input type="text" class="datetimepicker-input" id="datetimepickerEnd" name="eventEndDate"
                       data-toggle="datetimepicker" data-target="#datetimepickerEnd" placeholder="<?= $lang['end_date'] ?>" required/>

                <div class="imgpreview" id="preview" style="vertical-align:middle">
                    <img id="imgpreview" src="../resources/noimage.png"/>
                </div>

                <input type="hidden" id="imagePath" name="imagePath" value=""/>
                <div class="form-group upload-btn-wrapper">
                    <button class="btn"><?= $lang['upload_image'] ?></button>
                    <input type="file" id="browse" name="eventImage"/>
                </div>

                <textarea name="eventDescription" rows="8"
                          placeholder="<?= $lang['description'] ?>"></textarea><br/>

                <button type="submit" value="Envoyer"><?= $lang['save'] ?></button>
            </form>

        </div>
    </div>
</div>

<script src='../js/moment-with-locales.js'></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"/>

<script>
    //datetimepicker settings
    $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
        locale: 'fr',
        stepping: 15,
        sideBySide: true,
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar-alt',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'fas fa-times'
        }
    });

    $(function () {
        //Convert db dates to moments dates
        let datetimepickerStart = $('#datetimepickerStart');
        let datetimepickerEnd = $('#datetimepickerEnd');

        //datetimepicker init
        datetimepickerStart.datetimepicker({});

        datetimepickerEnd.datetimepicker({
            useCurrent: false
        });

        //datetimepicker listeners
        datetimepickerStart.on("change.datetimepicker", function (e) {
            $('#datetimepickerEnd').datetimepicker('minDate', e.date);
        });

        datetimepickerEnd.on("change.datetimepicker", function (e) {
            $('#datetimepickerStart').datetimepicker('maxDate', e.date);
        });
    });


</script>

<script>
    //fill up the select
    $(function () {
        //get the select
        let elementSelect = $("#elementLanguage");
        //add a listener to this select
        checkLanguageSelect(elementSelect, "elementLanguage", getCookie("siteLanguage"));
        //fill up the select with all avaibile languages
        buildLanguageSelect(elementSelect, "elementLanguage");
    });

</script>

<script src="../js/imagePreview.js"></script>

<?php include_once("footer.php") ?>
