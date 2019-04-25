<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 05.10.2018
 * Time: 10:02
 */

include_once(dirname(__DIR__) . "/global.php");

$categoryController = new CategoryController();

if(isset($_GET['method']) && $_GET['method'] == "getCategories")
{
    $languageId = $_POST['languageId'];
    echo $categoryController->loadCategories($languageId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "createCategory")
{
    $name = $_POST['name'];
    $price = $_POST['price'];
    $languageId = $_POST['languageId'];
    echo $categoryController->createCategory($name, $price, $languageId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "getCategoriesName")
{
    $languageId = $_POST['languageId'];
    echo $categoryController->getCategoriesName($languageId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "editCategory")
{
    $name = $_POST['name'];
    $price = $_POST['price'];
    $id = $_POST['id'];
    $languageId = $_POST['languageId'];
    echo $categoryController->editCategory($name, $price, $id, $languageId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "deleteCategory")
{
    $id = $_POST['id'];
    echo $categoryController->deleteCategory($id);
}

elseif(isset($_GET['method']) && $_GET['method'] == "changeLanguage")
{
    $languageId = $_POST['newLanguageId'];
    $id = $_POST['id'];
    echo $categoryController->changeLanguage($languageId, $id);
}

elseif(isset($_GET['method']) && $_GET['method'] == "updatePosition")
{
    $id = $_POST['id'];
    $newPosition = $_POST['newPosition'];
    echo $categoryController->updatePosition($id, $newPosition);
}

else
{
    echo "routing failed";
}

