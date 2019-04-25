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
$detailIngredient = fctIngredientList(1, $ingredientId);
//$listeIntolerances = fctFoodintoleranceList();

?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <h3>Supprimer un ingrédient</h3>
            <form class="cf1" method="post" action="../controller/ingredient_controller.php">
                <input type="hidden" name="action" value="ingredientDelete"/>
                <input type="text" name="ingredientName" size=50 placeholder="Nom de l'ingrédient"
                       value="<?= $detailIngredient[0]['NAME'] ?>" required autofocus/><br/>

                <input type="hidden" name="ingredientId" value=<?= $ingredientId ?> />

                <button type="submit">Supprimer</button>

            </form>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>
