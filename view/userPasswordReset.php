<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG // Edit Frank
 * Date: 25.09.2018
 * Time: 09:47
 */

include_once('header.php');
include_once('../model/user_model.php');

?>
<div class="container mt-5">
    <div class="row">
        <div class="col col-lg-6 col-md-8 col-12 centered">

            <div class="pageTitle"><?= $lang['password_reset_form'] ?></div>
            <div class="pageCaption"><?= $lang['password_reset_text'] ?></div>

            <form class="fform cf1" action="../controller/user_controller.php" method="post">
                <input name="action" value="passwordReset" type="hidden"/>

                <input type="email" name="email" placeholder="<?= $lang['email'] ?>" maxlength="128" required autofocus>

                <button type="submit" value="envoyer"><?= $lang['send'] ?></button>
            </form>

        </div>
    </div>
</div>
