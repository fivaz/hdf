<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 01/10/2018
 * Time: 23:05
 */

include_once('../model/ingredient_model.php');
//include_once('../view/IngredientEdit.php');

$target = "ingredients.php";

if (!isset($_POST['action'])) {
    header('Location: ../view/ingredients.php');
} else {
    $action = $_POST['action'];

    if ($action == 'ingredientAdd') {

        if (!isset($_POST['ingredientName'])) {
            echo "Form error: missing details";
            header('ingredient: ../view/ingredients.php');

        } else {
            $ingredientName = $_POST['ingredientName'];
//            $intoleranceLiaison = $_POST['. $intolerance["NAME"] .'];
            $lastid = fctIngredientAdd(1, $ingredientName);
            header('ingredient: ../view/ingredients.php');

//            header('location: ../view/ingredientEdit.php?id=' . $lastid);

        }

    } else if ($action == 'ingredientEdit') { // A MODIFIER !
        $target = "ingredients.php";

        if (!isset($_POST['ingredientName']) && !isset($_POST['ingredientId'])) {
            header('location: ../view/ingredients.php');

        } else {
            $ingredientName = $_POST['ingredientName'];
            $ingredientId = $_POST['ingredientId'];
            $languageId = $_POST['languageId'];

            fctIngredientEdit($ingredientId,$languageId,$ingredientName);

        }
//    } else if ($action == 'ingredientIntoAdd') {
//        $target = "ingredientDetail.php";
//
//        if (!isset($_POST['intoList']) && !isset($_POST['ingredientId'])) {
//            echo "Form error: missing details";
//            //check liste exist
//            //header('ingredient: ../view/ingredients.php');
//
//        } else {
//            $list = $_POST['intoList'];
//            $ingredientId = $_POST['ingredientId'];
//
//            //foreach lancer lien into - ingr
//            foreach ($list as $intolerance) {
//                fctIngredientIntoAdd($ingredientId, $intolerance);
//////           echo "<Option value='".$intolerance['FOOD_ID']."'>" . $intolerance['NAME'] . "</Option>";
//            }
//        header('Location: ../view/ingredients.php');
//
//        }
//    } else {
//        header('Location: ../view/ingredients.php');

    } elseif ($action == 'ingredientDelete'){
        $target ="ingredients.php";

        if (!isset($_POST['ingredientName']) && !isset($_POST['ingredientId'])) {
            header('location: ../view/ingredients.php');

        } else {
            $ingredientName = $_POST['ingredientName'];
            $ingredientId = $_POST['ingredientId'];

            fctIngredientDelete($ingredientId);

        }
    }
//    header('Location: ../view/' . $target.'?id='.$lastid); //exemple avec id
header('location: ../view/' . $target);
}
