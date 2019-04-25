<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 10.10.2018
 * Time: 16:53
 */

include_once(dirname(__DIR__) . "/global.php");

$ingredientController = new IngredientController();

if(isset($_GET['method']) && $_GET['method'] == "getIngredients")
{
    $languageId = $_POST['languageId'];
    $articleId = $_POST['articleId'];
    echo $ingredientController->loadIngredients($languageId, $articleId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "attachIngredient")
{
    $ingredientId = $_POST['ingredientId'];
    $articleId = $_POST['articleId'];

    echo $ingredientController->attachIngredient($ingredientId, $articleId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "detachIngredient")
{
    $ingredientId = $_POST['ingredientId'];
    $articleId = $_POST['articleId'];

    echo $ingredientController->detachIngredient($ingredientId, $articleId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "getIngredientsByName")
{
    $ingredientName = $_POST['ingredientName'];
    $languageId = $_POST['languageId'];

    echo $ingredientController->selectIngredientName($ingredientName, $languageId);
}


else
{
    echo "routing failed";
}

