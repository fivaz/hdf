<?php
/**
 * Created by PhpStorm.
 * User: MAHESALINGAM_MI-ESIG
 * Date: 10.10.2018
 * Time: 10:13
 */

include_once('header.php');

$locationId = $_GET['id'];

include_once('../model/location_model.php');
$day = 0;
//$detailEmplacement = fctLocationList($locationId);

$languageId = 1;

if(isset($_COOKIE['elementLanguage'])){
    $languageId = $_COOKIE['elementLanguage'];
}

$detailEmplacement = getLocation($locationId, $languageId);

?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <h3>Modifier un emplacement</h3>
            <form class="cf1" method="post" action="../controller/location_controller.php">

                <select name="languageId" id="elementLanguage"></select>

                <input type="text" name="locationTitle" size=50 placeholder="NOM EMPLACEMENT"
                       value="<?=$detailEmplacement[0]['TITLE']?>" required
                       autofocus/><br/>
                <input type="text" name="locationAddress" size=50 placeholder="ADRESSE"
                       value="<?= $detailEmplacement[0]['ADDRESS'] ?>" required/>
                <textarea name="locationDescription"
                          placeholder="DESCRIPTION"><?= $detailEmplacement[0]['DESCRIPTION'] ?></textarea>

                <select name="locationDay">
                    <option value="0">---</option>
                    <option value="1">Lundi</option>
                    <option value="2">Mardi</option>
                    <option value="3">Mercredi</option>
                    <option value="4">Jeudi</option>
                    <option value="5">Vendredi</option>
                    <option value="6">Samedi</option>
                    <option value="7">Dimanche</option>

                </select>

                <select name="locationType">
                    <option value="restaurant">Restaurant</option>
                    <option value="foodtruck">Food Truck</option>
                </select>


                <input type="hidden" name="locationId" value="<?= $detailEmplacement[0]['LOCA_ID'] ?>"/>
                <input type="hidden" name="action" value="locationEdit"/>

                <button type="submit">Modifier</button>

            </form>
        </div>
    </div>
</div>

<script>

    $(function()
    {
        let selectElement = $("#elementLanguage");
        checkLanguageSelect(selectElement, "elementLanguage", getCookie("siteLanguage"));
        buildLanguageSelect(selectElement, "elementLanguage");
    });

</script>

<?php include_once('footer.php'); ?>
