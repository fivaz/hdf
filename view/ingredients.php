<?php
/**
 * Created by PhpStorm.
 * User: Mithul
 * Date: 01/10/2018
 * Time: 20:36
 */

include_once('header.php');

//include_once('../model/foodintolerance_model.php');
include_once('../model/ingredient_model.php');
//$listeIntolerances = fctFoodintoleranceList();


$languageId = 1;

if(isset($_COOKIE['siteLanguage'])){
    $languageId = $_COOKIE['siteLanguage'];
}

$listeIngredients = fctIngredientList($languageId);
?>

<div class="row">

    <div class="container center col-5" style="height:450px;">
        <br/>
        <a style="position: absolute; right:10px" class="m-1" href="#" data-toggle="modal" data-target="#ingredientAddModal"><i class="fas fa-plus-circle fa-2x"></i></a>
        <h3 class = 'pageTitle'><?=$lang['ingredient_list']?></h3>

        <?php
        foreach ($listeIngredients as $ingredient) {
        //            echo $ingredient['NAME'] . "<a href='IngredientEdit.php?id=" . $ingredient['INGR_ID'] . "'>modifier</a><a href='ingredientDelete.php?id=" . $ingredient['INGR_ID'] . "'>supprimer</a><br/>";
       ?>

            <div class="dropdown dropright float-right">

                <i type="button" class="fa fa-ellipsis-h fa-1x" data-toggle="dropdown"></i>

                <div class="dropdown-menu">
                    <a class="dropdown-item"
                       href="IngredientEdit.php?id=<?= $ingredient['INGR_ID'] ?>"><?=$lang['ingredient_edit']?></a>
                    <!--                <a class="dropdown-item"-->
                    <!--                   href="IngredientEdit.php?id=--><?//= $ingredient['INGR_ID'] ?><!--" data-toggle="modal" data-target="#ingredientAddModal">Modifier</a>-->
                    <a class="dropdown-item" href="ingredientDelete.php?id=<?= $ingredient['INGR_ID'] ?>"><?=$lang['ingredient_delete']?></a>
                </div>
            </div>


       <?php

        echo "<p class ='pageCaption'>".$ingredient['NAME']."</p>"; ?>


        <?php
        }?>

    </div>

</div>
<!--</div>-->


<div id="ingredientAddModal" class="modal mt-auto fade">
    <div class="modal-dialog  modal-dialog-centered ">
        <div class="modal-content cf1">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><?=$lang['ingredient_add']?></h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form class="cf1" action="../controller/ingredient_controller.php" method="post">



                    <input type="hidden" name="action" value="ingredientAdd"/>
                    <input type="text" name="ingredientName" size=50 placeholder="NOM INGREDIENT" required
                           autofocus/><br/>

                    <button type="submit">Ajouter</button>

                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div id="ingredientEditModal" class="modal mt-auto fade">
    <div class="modal-dialog  modal-dialog-centered ">
        <div class="modal-content cf1">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modifier un ingrédient</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form class="cf1" action="../controller/ingredient_controller.php" method="post">



                    <select name="languageId" id="elementLanguage"></select>

                    <input type="text" name="ingredientName" size=50 placeholder="Nom de l'ingrédient"
                           value="<?= $detailIngredient[0]['NAME'] ?>" required autofocus/><br/>

                    <input type="hidden" name="ingredientId" value=<?= $ingredientId ?> />
                    <input type="hidden" name="action" value="ingredientEdit"/>

                    <button type="submit">Modifier</button>

                </form>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>


<?php include_once('footer.php'); ?>
