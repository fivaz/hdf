<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 10.10.2018
 * Time: 16:53
 */

include_once(dirname(__DIR__) . "/global.php");

$articleController = new ArticleController();

if(isset($_GET['method']) && $_GET['method'] == "getArticles")
{
    $languageId = $_POST['languageId'];
    $categoryId = $_POST['categoryId'];
    echo $articleController->loadArticles($languageId, $categoryId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "toggleHighlight")
{
    $articleId = $_POST['articleId'];
    echo $articleController->toggleHighlight($articleId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "createArticle")
{
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $categoryId = $_POST['categoryId'];
    $languageId = $_POST['languageId'];
    echo $articleController->createArticle($name, $price, $description, $categoryId, $languageId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "editArticle")
{
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
//    $categoryId = $_POST['categoryId'];
    $id = $_POST['id'];
    $languageId = $_POST['languageId'];
    echo $articleController->editArticle($id, $name, $price, $description, /*$categoryId,*/ $languageId);
}

elseif(isset($_GET['method']) && $_GET['method'] == "deleteArticle")
{
    $id = $_POST['id'];
    echo $articleController->deleteArticle($id);
}
/*create a super method to edit article with all other edits*/

/*change language becomes edit language*/

elseif(isset($_GET['method']) && $_GET['method'] == "changeLanguage")
{
    $languageId = $_POST['newLanguageId'];
    $id = $_POST['id'];
    echo $articleController->changeLanguage($languageId, $id);
}

/*outdated*/
elseif(isset($_GET['method']) && $_GET['method'] == "editPosition")
{
    $id = $_POST['id'];
    $position = $_POST['position'];
    echo $articleController->editPosition($id, $position);
}

elseif(isset($_GET['method']) && $_GET['method'] == "updatePosition")
{
    $id = $_POST['articleId'];
    $position = $_POST['articleNewPosition'];

    echo $articleController->updatePosition($id, $position);
}

elseif(isset($_GET['method']) && $_GET['method'] == "updateCategory")
{
    $id = $_POST['articleId'];
    $newCategoryId = $_POST['newCategoryId'];

    echo $articleController->updateCategory($id, $newCategoryId);
}
else
{
    echo "routing failed";
}

