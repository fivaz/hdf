<?php
/**
 * Calendar display
 * User: Frank Théodoloz
 * Date: 04/10/2018
 * Time: 21:05
 */

include_once('header.php');
if (isset($_SESSION['user']['PRIVILEGE']) && $_SESSION['user']['PRIVILEGE'] == 1) {
    $privilege = 1;
} else {
    $privilege = 0;
}
?>
<link rel='stylesheet' href='../css/fullcalendar.css'/>

<script src='../js/moment-with-locales.js'></script>
<script src='../js/fullcalendar.js'></script>
<script src='../js/fullcalendar_load.js'></script>

<div class="row center">

    <div class="col col-lg-4 col-12 mt-4">
        <div class="pageTitle"><?= $lang['calendar_title'] ?></div>
        <div class="pageCaption"><?= $lang['calendar_text1'] ?></div>
        <div class="pageCaption"></div>
        <a href="event.php"><?= $lang['calendar_text2'] ?></a>

        <?php if ($privilege == 1) { ?>
            <br/>
            <a href="eventAdd.php"><?= $lang['event_add'] ?></a>
        <?php } ?>

    </div>

    <div class="col col-lg-8 col-12 mt-lg-4 mt-3">
        <div id='calendar'></div>
    </div>
</div>

<div id="eventModal" class="modal mt-auto fade">
    <div class="modal-dialog modal-dialog-centered fform">
        <div class="modal-content cf1">

            <div class="modal-header">
                <h4 id="modalTitle" class="modal-title">
                    <div id="eventTitle" class="h1"></div>
                </h4>
            </div>

            <div id="modalBody" class="modal-body">
                <div id="eventDescription" class=""></div>
                <hr/>
                <div><span><?= $lang['from'] ?> </span><span id="eventDateStart" class=""></span></div>
                <div><span><?= $lang['to'] ?> </span><span id="eventDateEnd" class=""></span></div>
                <a id="eventLinkLnk" href=""><div id="eventLink" class=""></div></a><div id="eventLink" class=""></div>
                <div id="eventImageDiv">
                    <img class="imgpreview boxed my-2" src="" id="eventImage"/>
                </div>
                <h6><span><?= strtolower($lang['address']) ?> : </span><span id="eventAddress" class=""></span></h6>
            </div>

            <div class="modal-footer">
                <?php if ($privilege == 1) { ?>
                    <button id="eventEditBtn" type="button" class="cf1"><?= $lang['edit'] ?></button>
                <?php } ?>
                <button type="button" class="cf1" data-dismiss="modal"><?= $lang['close'] ?></button>
            </div>

        </div>
    </div>
</div>

<?php include_once('footer.php') ?>
