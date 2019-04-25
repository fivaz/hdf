<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 01/10/2018
 * Time: 20:36
 */

include_once('header.php');

include_once('../model/foodintolerance_model.php');
$listeIntolerances = fctFoodintoleranceList();
?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <h3>Ajouter une intolérance</h3>
            <form class="cf1" method="post" action="../controller/intolerance_controller.php">
                <input type="text" name="intoleranceName" size=50 placeholder="NOM INTOLERANCE" required
                       autofocus/><br/>
                <button type="submit" value="Ajouter">Ajouter</button>
            </form>

            <br/>
            <h3>Liste des intolérances</h3>

            <?php foreach ($listeIntolerances as $intolerance) {
                echo $intolerance['NAME'] . "<a href='intoleranceEdit.php?id=" . $intolerance['FOOD_ID'] . "'>modifier</a><br/>";
            } ?>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>
