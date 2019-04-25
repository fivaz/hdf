<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 01/10/2018
 * Time: 20:36
 */

include_once('header.php');

//include_once('../model/foodintolerance_model.php');
include_once('../model/ingredient_model.php');
//$listeIntolerances = fctFoodintoleranceList();
$listeIngredients = fctIngredientList(1);
?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <h3>Ajouter un ingrédient</h3>
            <form class="cf1" method="post" action="../controller/ingredient_controller.php">
                <input type="hidden" name="action" value="ingredientAdd"/>
                <input type="text" name="ingredientName" size=50 placeholder="NOM INGREDIENT" required
                       autofocus/><br/>

                <!--    <SELECT name="intoleranceLiaison" size="1">-->
                <!--        <option>Aucune</option>-->
                <!--        -->
                <!---->
                <!--    </SELECT><br/>-->
                <button type="submit" value="Ajouter">Ajouter</button>

            </form>
        </div>
        <br/>

    </div>
</div>


<?php include_once('footer.php'); ?>
