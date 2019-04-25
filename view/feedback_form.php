<?php
/**
 * Created by PhpStorm.
 * User: Mithul
 * Date: 01/10/2018
 * Time: 23:04
 */

include_once('header.php');

include_once('../model/user_model.php');

//voir si $session existe


if (!isset($_SESSION["user"]["USER_ID"])) {
    $userId = 0;
} else {
    $userId = $_SESSION["user"]["USER_ID"];
}

?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <h3><?=$lang['feedback_send']?></h3>
            <form class="cf1" method="post" action="../controller/feedback_controller.php">

                <!--    si l'user est connu on met son nom et désactive le champ-->
                <input type="hidden" name="userId" value="<?= $userId ?>"/>

                <?php
                if ($userId > 0) {
                    $userDetail = fctUserList($userId);
                    $userName = $userDetail[0]['FIRST_NAME'] . ' ' . $userDetail[0]['LAST_NAME'];
                    $userEmail = $userDetail[0]['EMAIL'];
                    echo('<input required type="text" name="Name"  size="50" placeholder=""  value="' . $userName . '" disabled /><br/>
    <input required type="email" name="feedbackEmail" placeholder="Votre E-mail" value="' . $userEmail . '" size="50" disabled/><br/>
');
                } else {
//    $userName = "";
                    echo('<input type="text" name="Name" size=50 placeholder="NOM, PRENOM" autofocus required/><br/>
<input type="email" name="feedbackEmail" placeholder="EMAIL" size="50" required/><br/>');


                }
                ?>

                <input type="text" name="feedbackTitle" placeholder="TITRE" size="50" required/><br/>
                <input required type="number" name="feedbackNumber" placeholder="NOTE" min="1" max="5"><br/>
                <textarea required name="feedbackMessage" cols="43" rows="8" placeholder="MESSAGE"></textarea><br/>
                <input type="hidden" name="action" value="feedbackSend"/>
<!--                <p>Votre avis ne sera pris en compte qu'après validation de votre adresse email</p>-->
                <p><?=$lang['feedback_info']?></p>
                <button type="submit" value="Envoyer"><?= $lang['send'] ?></button>
            </form>

        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>

