<?php
/**
 * Created by PhpStorm.
 * User: MAHESALINGAM_MI-ESIG
 * Date: 08.10.2018
 * Time: 15:18
 */

include_once('header.php');

$ingredientId = $_GET['id'];

include_once('../model/ingredient_model.php');
//include_once('../model/foodintolerance_model.php');

$languageId = 1;

if(isset($_COOKIE['elementLanguage'])){
    $languageId = $_COOKIE['elementLanguage'];
}

$detailIngredient = getIngredient($languageId, $ingredientId);
//$listeIntolerances = fctFoodintoleranceList();

?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <h3>Modifier un ingrédient</h3>
            <form class="cf1" method="post" action="../controller/ingredient_controller.php">

                <select name="languageId" id="elementLanguage"></select>

                <input type="text" name="ingredientName" size=50 placeholder="Nom de l'ingrédient"
                       value="<?= $detailIngredient[0]['NAME'] ?>" required autofocus/><br/>

<!--                <h3>Rattacher à une intolérance</h3>-->
<!---->
<!--                --><?php //foreach ($listeIntolerances as $intolerance) {
//                    echo '<input type="checkbox" name="intoList[]" value="' . $intolerance['FOOD_ID'] . '"> ' . $intolerance["NAME"] . '<br/>';
//                } ?>
<!---->
<input type="hidden" name="ingredientId" value=<?= $ingredientId ?> />
         <input type="hidden" name="action" value="ingredientEdit"/>
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
