<?php
/**
 * Contact form
 * User: Frank Théodoloz
 * Date: 01/10/2018
 * Time: 20:36
 */

include_once('header.php');
include_once('../model/parameter_model.php');

//voir si $session existe
if (isset($_SESSION["user"]["id"])) {
    $userId = $_SESSION["user"]["id"];
} else {
    $userId = 0;
}
?>

    <!-- Google reCaptcha (oliv3r80@gmail.com) -->
    <script src="../js/recaptcha_load.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

    <div class="container mt-5">
        <div class="row">
            <div class="col col-lg-6 col-md-8 col-12 centered">

                <form class="cf1" method="post" action="../controller/contact_controller.php">
                    <input type="hidden" name="action" value="contact"/>

                    <a class="email" href="mailto:<?= fctParameterGet("CONTACT_EMAIL") ?>"><?= fctParameterGet('CONTACT_EMAIL') ?></a>

                    <input type="text" name="contactName" placeholder="<?= $lang['name'] ?>" required
                           autofocus/>
                    <input type="email" name="contactEmail" placeholder="<?= $lang['email'] ?>"/>
                    <input type="text" name="contactSubject" placeholder="<?= $lang['subject'] ?>"/>
                    <textarea rows="5" name="contactMessage"
                              placeholder="<?= $lang['message'] ?>"></textarea>
                    <button id="submitButton" type="submit"><?= $lang['send'] ?></button>

                    <!-- Google reCaptcha-->
                    <div id="g-recaptcha"></div>

                </form>
            </div>
        </div>
    </div>

<?php include_once("footer.php"); ?>