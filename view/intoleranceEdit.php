<?php
/**
 * Created by PhpStorm.
 * User: MAHESALINGAM_MI-ESIG
 * Date: 08.10.2018
 * Time: 15:18
 */

include_once('header.php');

$intoleranceId = $_GET['id'];

include_once('../model/foodintolerance_model.php');
$detailIntolerance = fctFoodintoleranceList(1, $intoleranceId);

?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <h3>Modifier une intolérance</h3>
            <form class="cf1" method="post" action="../controller/intolerance_controller.php">
                <input type="text" name="intoleranceName" size=50 placeholder="Nom de l'intolérance"
                       value="<?= $detailIntolerance[0]['NAME'] ?>" required autofocus/><br/>

                <input type="hidden" name="action" value="ingredientIntoAdd"/>
                <button type="submit">Modifier</button>

            </form>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>
