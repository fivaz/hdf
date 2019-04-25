<?php
/**
 * Event edit form
 * User: Frank Théodoloz
 * Date: 18.10.2018
 * Time: 11:13
 */

include_once('header.php');
include_once('../model/calendar_model.php');

//get the current language of this element
$languageId = $_COOKIE['elementLanguage'];

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $eventId = $_GET['id'];

    //get data with this language
    $eventDetail = fctCalendarEventDetail($languageId, $eventId);
    $eventImage = base64_encode($eventDetail['IMAGE']);

    //datetime formats: db = 2018-01-01 17:00 'Y-m-d H:i' fr locale = 01-01-2018 17:00 'd/m/Y H:i'
    $datetimeStart = $eventDetail['DATETIME_START'];
    $datetimeEnd = $eventDetail['DATETIME_END'];

} else {

    header('location: ../view/calendar.php');

}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col col-lg-6 col-md-8 col-12 cf1 centered">

            <div class="pageTitle"><?= $lang['event_edit'] ?></div>
            <a href="../view/calendar.php"><?= $lang['calendar_back'] ?></a>

            <!--it's the select to manage the languages of the element warning: the id must be different from siteLanguage-->
            <input class="cf1" type="hidden" name="languageId" value="<?= $_COOKIE['siteLanguage'] ?>">
            <select id="elementLanguage" name="languageId" style="float:right">
                <!--the options are filled up by a js function-->
            </select>

            <form class="cf1" method="post" action="../controller/event_controller.php">
                <input type="hidden" name="action" value="eventEdit"/>
                <input type="hidden" name="eventId" value="<?= $eventId ?>"/>
                <input type="hidden" name="calendarId" value="<?= $eventDetail['CALE_ID'] ?>"/>
                <input type="hidden" name="languageId" value="<?= $languageId ?>"/>

                <input type="text" name="eventTitle" placeholder="<?= $lang['event_name'] ?>"
                       value="<?= $eventDetail['TITLE'] ?>" autofocus required/><br/>
                <input type="text" name="eventAddress" placeholder="<?= $lang['address'] ?>"
                       value="<?= $eventDetail['ADDRESS'] ?>" autofocus required/><br/>
                <input type="text" class="datetimepicker-input" id="datetimepickerStart" name="eventStartDate"
                       data-toggle="datetimepicker" data-target="#datetimepickerStart" placeholder="<?= $lang['start_date'] ?>" required/>
                <input type="text" class="datetimepicker-input" id="datetimepickerEnd" name="eventEndDate"
                       data-toggle="datetimepicker" data-target="#datetimepickerEnd" placeholder="<?= $lang['end_date'] ?>" required/>

                <?php
                if ($eventImage) { //existing image ?>
                    <img class="imgpreview my-3" src="data:image/jpeg;base64, <?= $eventImage ?>"/>
                <?php } else { //no image ?>
                    <img class="imgpreview my-3" src="../resources/noimage.png"/>
                <?php } ?>

                <button type="button" class="mb-3" data-toggle="modal" data-target="#imageModal">Edit image</button>
                <textarea name="eventDescription" rows="8"
                          placeholder="<?= $lang['event_description'] ?>"><?= $eventDetail['DESCRIPTION'] ?></textarea><br/>

                <button id="deleteBtn" type="button" style="float:left"><?=$lang['remove']?></button>
                <button id="submitButton" type="submit" value="Envoyer"><?= $lang['save'] ?></button>
            </form>

        </div>
    </div>
</div>

<div id="imageModal" class="modal mt-auto fade">
    <div class="modal-dialog modal-dialog-centered fform">
        <div class="modal-content cf1">

            <form class="cf1" method="post" action="../controller/event_controller.php" enctype="multipart/form-data">
                <input type="hidden" name="eventId" value="<?= $eventId ?>"/>
                <input type="hidden" name="action" value="eventEditImage"/>

                <div class="modal-header">
                    <h4 id="modalTitle" class="modal-title">Image update</h4>
                </div>

                <div id="modalBody" class="modal-body">
                    <div id="preview" style="vertical-align:middle">
                        <?php if ($eventImage) {  //existing image ?>
                            <img class="imgpreview " id="imgpreview" src="data:image/jpeg;base64, <?= $eventImage ?>"/>
                        <?php } else { //no image ?>
                            <img class="imgpreview" id="imgpreview" src="../resources/noimage.png"/>
                        <?php } ?>
                    </div>

                    <div class="form-group upload-btn-wrapper my-2">
                        <button type="button" class="btn"><?= $lang['upload_image'] ?></button>
                        <br/>
                        <input type="file" id="browse" name="eventImage"/>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"><?= $lang['close'] ?></button>
                    <button type="submit" value="Envoyer"><?= $lang['save'] ?></button>
                </div>

            </form>

        </div>
    </div>
</div>

<div id="deleteModal" class="modal mt-auto fade">
    <div class="modal-dialog modal-dialog-centered fform">
        <div class="modal-content cf1">

            <form class="cf1" method="post" action="../controller/event_controller.php" enctype="multipart/form-data">
                <input type="hidden" name="eventId" value="<?= $eventId ?>"/>
                <input type="hidden" name="action" value="eventDelete"/>

                <div class="modal-header">
                    <h4 id="modalTitle" class="modal-title"><?=$lang['delete_confirm_title']?></h4>
                </div>

                <div id="modalBody" class="modal-body">
                    <?=$lang['delete_confirm_text']?>
                </div>

                <div class="modal-footer">
                    <button type="submit" value="Envoyer"><?= $lang['confirm'] ?></button>
                    <button type="button" data-dismiss="modal"><?= $lang['cancel'] ?></button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php include_once("footer.php") ?>

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
        let startDate = moment('<?=$datetimeStart?>', 'yyyy-mm-dd hh:mm:ss').toDate();
        let endDate = moment('<?=$datetimeEnd?>', 'yyyy-mm-dd hh:mm:ss').toDate();

        //datetimepicker init
        datetimepickerStart.datetimepicker({
            date: startDate
        });

        datetimepickerEnd.datetimepicker({
            date: endDate,
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

<script src="../js/imagePreview.js"></script>

<script>
    $(function () {
        //imageModal listener
        $('#imgpreview1').click(function () {
            $("#imageModal").modal()
        });

        //deleteModal listener
        $('#deleteBtn').click(function () {
            $("#deleteModal").modal()
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
