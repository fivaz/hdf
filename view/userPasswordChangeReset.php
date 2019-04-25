<?php
/**
 * Password change reset form
 * Ce formulaire prend en paramètre le token et le renvoie avec le nouveau password au controller
 * User: Frank Théodoloz
 * Date: 29/10/2018
 * Time: 23:14
 */

if (isset($_GET['token'])) {
    $token = $_GET['token'];

} else {
    header("location: ../view/main.php");
}

include_once('header.php');

?>
    <div class="container mt-5">
        <div class="row">
            <div class="col col-lg-6 col-md-8 col-12 centered">

                <h1><?= $lang['password_change_form'] ?></h1>

                <form class="fform cf1" action="../controller/user_controller.php" method="post">
                    <input type="hidden" name="action" value="passwordResetProcess"/>
                    <input type="hidden" name="token" value="<?= $token ?>"/>

                    <input type="password" name="password" placeholder="<?= $lang['new_password'] ?>" required><br/>
                    <!--                    <input type="password" name="password" id="PASSWORD_HASH" placeholder="--><? // // //=$lang['password_confirm']?><!--" required>-->

                    <button type="submit"><?= $lang['change'] ?></button>

                </form>

            </div>
        </div>
    </div>

<?php include_once('footer.php'); ?>