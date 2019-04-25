<?php
/**
 * Password change Form
 * User: CABRERA_DANIEL-ESIG // Edit Frank
 * Date: 25.09.2018
 * Time: 09:47
 */

include_once('header.php');

?>
    <div class="container mt-5">
        <div class="row">
            <div class="col col-lg-6 col-md-8 col-12 centered">

                <h1><?= $lang['password_change_form'] ?></h1>

                <form class="fform cf1" action="../controller/user_controller.php" method="post">
                    <input type="hidden" name="action" value="passwordChange"/>

                    <input type="password" name="password" placeholder="<?= $lang['new_password'] ?>" required><br/>
                    <!--                    <input type="password" name="password" id="PASSWORD_HASH" placeholder="--><? // // //=$lang['password_confirm']?><!--" required>-->

                    <button type="submit"><?= $lang['change'] ?></button>

                </form>

            </div>
        </div>
    </div>

<?php include_once('footer.php'); ?>