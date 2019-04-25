<?php
/**
 * Created by PhpStorm.
 * User: MAHESALINGAM_MI-ESIG
 * Date: 08.10.2018
 * Time: 15:18
 */

include_once('header.php');

$feedbackId = $_GET['id'];

include_once('../model/feedback_model.php');
//include_once('../model/foodintolerance_model.php');
$detailfeedback = fctfeedbackList($feedbackId);
//$listeIntolerances = fctFoodintoleranceList();

?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <h3>Supprimer un avis</h3>
            <form class="cf1" method="post" action="../controller/feedback_controller.php">
                <input type="hidden" name="action" value="feedbackDelete"/>
                <input type="text" name="feedbackName" size=50 placeholder="Nom de l'avis"
                       value="<?= $detailfeedback[0]['TITLE'] ?>" required autofocus/><br/>

                <input type="hidden" name="feedbackId" value=<?= $feedbackId ?> />

                <button type="submit">Supprimer</button>

            </form>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>
