<?php
/**
 * Customer event proposition form
 * Add the event to the event list (unconfirmed) and send an email
 * User: Frank Théodoloz
 * Date: 05.10.2018
 * Time: 11:40
 */

include_once('header.php')
?>

<!-- Google reCaptcha (oliv3r80@gmail.com) -->
<script src="../js/recaptcha_load.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

<!--http://learn.jquery.com/jquery-ui/getting-started/-->
<link rel="stylesheet" href="../bin/jquery-ui/jquery-ui.min.css">
<script src="../bin/jquery-ui/jquery-ui.min.js"></script>

<div class="container mt-5">
    <div class="row">
        <div class="col col-lg-6 d-lg-block d-sm-none d-none mt-1 centered">

            <div class="image-container mb-4">
                <div class="item" style="position:absolute;">
                    <img class="wp1link" src="../resources/event/foodtruck.jpg"/>
                    <div class="wp1_left wp1_shd"></div>
                    <div class="wp1_right wp1_shd"></div>
                </div>
            </div>

            <div>
                <h4><?= $lang['calendar_link'] ?></h4>
            </div>

        </div>

        <div class="col col-lg-6 col-md-9 col-sm-12 mt-1 centered">
            <div class="pageTitle"><?= $lang['event_title'] ?></div>
            <div class="pageCaption"><?= $lang['event_text1'] ?></div>
            <div class="pageCaption"><?= $lang['event_text2'] ?></div>

            <form method="post" action="../controller/contact_controller.php">
                <input type="hidden" name="action" value="proposition"/>

                <div class="cf1">

                    <input type="text" name="eventName" placeholder="<?= $lang['name'] ?>" required autofocus/>

                    <input type="text" class="datetimepicker-input" id="datetimepicker" name="eventDate"
                           data-toggle="datetimepicker" data-target="#datetimepicker" placeholder="<?= $lang['event_date'] ?>" required/>

                    <input type="email" name="eventContactEmail" placeholder="<?= $lang['email'] ?>"
                           required/><br/>
                    <input type="text" name="eventContactPhone" placeholder="<?= $lang['phone'] ?>"/><br/>
                    <textarea rows="5" name="eventContactMessage" placeholder="<?= $lang['message'] ?>"></textarea>

                    <button id="submitButton" type="submit"><?= $lang['send'] ?></button>

                    <!-- Google reCaptcha-->
                    <div id="g-recaptcha"></div>

                </div>
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
        $('#datetimepicker').datetimepicker({
            useCurrent: false
        });
    });


</script>

<script>
    //this is a script that computes the position of the .item based on the height of the .container
    $(function () {
        let y = 0;
        $('.image-container .item').each(function () {
            y = Math.max(y, $(this).height() + $(this).position().top) + 10;
        });

        $('.image-container').css('height', y);
    });
</script>

<?php include_once('footer.php') ?>

