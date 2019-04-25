<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 05.10.2018
 * Time: 10:04
 */

class ArticleController
{
    public $model;

    public function __construct()
    {
        $this->model = new ArticleModel();
    }

    public function loadArticles($languageId, $categoryId)
    {
//        $articles = $this->model->selectJoin($languageId, $categoryId, "CATE_ID");
        $articles = $this->model->selectJoinOrdered($languageId, $categoryId, "CATE_ID");
        return json_encode($articles);
    }

    public function toggleHighlight($articleId)
    {
        $article = $this->model->find($articleId);
        $isHighlight = $article->getAttr("ISHIGHLIGHT");
        $article->setAttr("ISHIGHLIGHT",!$isHighlight);
        $result = $article->update();
        return json_encode($result);
    }

    public function createArticle($name, $price, $description, $categoryId, $languageId)
    {
        $this->model->setAttr("PRICE", $price);
        $this->model->setAttr("CATE_ID", $categoryId);

        $nextPosition = $this->model->getNextPosition("CATE_ID", $categoryId);

        $this->model->setAttr("POSITION", $nextPosition);
        $this->model->langModel->setAttr("NAME", $name);
        $this->model->langModel->setAttr("DESCRIPTION", $description);
        $this->model->langModel->setAttr("LANG_ID", $languageId);
        $this->model->create();
        $columnId = $this->model->columnId;
        $id = $this->model->getId();
        $article = $this->model->selectJoin($languageId, $id, $columnId);
        return json_encode($article);
    }

    public function editArticle($id, $name, $price, $description, /*$categoryId,*/ $languageId)
    {
        $this->model->find($id);
        $this->model->setAttr("PRICE", $price);
//        $this->model->setAttr("CATE_ID", $categoryId);
        $this->model->langModel->setAttr("MENU_ID", $id);
        $this->model->langModel->setAttr("NAME", $name);
        $this->model->langModel->setAttr("DESCRIPTION", $description);
        $this->model->langModel->setAttr("LANG_ID", $languageId);
        $result = $this->model->update();
        return json_encode($result);
    }

    public function deleteArticle($id){
        $results = array();

        $result = $this->model->langModel->delete($id);
        array_push($results, $result);

        $result = $this->model->delete($id);
        array_push($results, $result);

        return json_encode($results);
    }

    public function changeLanguage($languageId, $id)
    {
        $result = $this->model->selectJoin($languageId, $id);
        if($result)
        {
            return json_encode($result);
        }
        else
        {
            $this->model->langModel->setAttr($this->model->columnId, $id);
            $this->model->langModel->setAttr("LANG_ID", $languageId);
            $this->model->langModel->create();
//            var_dump($result);
            $result = $this->model->selectJoin($languageId, $id);
            return json_encode($result);
        }
    }

    /*outdated*/
    public function editPosition($id, $position){
        $article = $this->model->find($id);
        $article->setAttr("POSITION", $position);
        return json_encode($article->update());
    }

    public function updatePosition($id, $position){
        $article = $this->model->find($id);
        $article->setAttr("POSITION", $position);
        return json_encode($article->update());
    }

    public function updateCategory($id, $newCategoryId){
        $article = $this->model->find($id);
        $article->setAttr("CATE_ID", $newCategoryId);
        return json_encode($article->update());
    }

    public function deleteAll()
    {
        return $this->model->deleteAll();
    }

    public function seed()
    {
        /*THE HOT DOG*/

        $this->model->createArticle("1", "1",
            "THE CLASSIC FR",
            "Pain classique artisanal, saucisse de porc 100 % suisse artisanale, ketchup, chou au vinaigre balsamique blanc.",
            "10.00", "0", "", 1, 1,  1);
        $this->model->addLang("1",
            "THE CLASSIC EN",
            "Pain classique artisanal, saucisse de porc 100 % suisse artisanale, ketchup, chou au vinaigre balsamique blanc.",
            "2");

        $this->model->createArticle("2", "1",
            "THE BARBECUE",
            "Pain oignons artisanal, saucisse de veau 100 % suisse artisanale, salade iceberg et sauce barbecue deglace.",
            "10.00", "0", "", 2, 1,  1);
        $this->model->addLang("2",
            "THE BARBECUE",
            "Pain oignons artisanal, saucisse de veau 100 % suisse artisanale, salade iceberg et sauce barbecue deglace.",
            "2");

        $this->model->createArticle("3", "1",
            "THE TASTY",
            "Pain multi-grains artisanal, salade iceberg, saucisse de boeuf/agneau 100% suisse artisanale, et sauce tartare.",
            "10.00", "0", "", 3, 1,  1);
        $this->model->addLang("3",
            "THE TASTY",
            "Pain multi-grains artisanal, salade iceberg, saucisse de boeuf/agneau 100% suisse artisanale, et sauce tartare.",
            "2");

        /*THE DRINKS*/

        $this->model->createArticle("6", "3",
            "Café",
            "",
            "2.50", "0", "", 1, 1,  1);
        $this->model->addLang("6",
            "Café",
            "",
            "2");

        $this->model->createArticle("7", "3",
            "Thé",
            "",
            "2.50", "0", "", 2, 1,  1);
        $this->model->addLang("7",
            "Thé",
            "",
            "2");

        $this->model->createArticle("8", "3",
            "Cafe gourmand",
            "",
            "2.50", "0", "", 3, 1,  1);
        $this->model->addLang("8",
            "Cafe gourmand",
            "",
            "2");

        $this->model->createArticle("9", "3",
            "The gourmand",
            "",
            "2.50", "0", "", 4, 1,  1);
        $this->model->addLang("9",
            "The gourmand",
            "",
            "2");

        /*THE DESSERT*/

        $this->model->createArticle("4", "2",
            "Brownie maison",
            "",
            "10.00", "0", "", 1, 1,  1);
        $this->model->addLang("4",
            "Brownie maison",
            "",
            "2");

        $this->model->createArticle("5", "2",
            "Cookie maison",
            "",
            "10.00", "0", "", 2, 1,  1);
        $this->model->addLang("5",
            "Cookie maison",
            "",
            "2");

        /*THE EXTRA*/

        $this->model->createArticle("10", "4",
            "Pot de nachos sauce sweet chili",
            "",
            "2.00", "0", "", 1, 1,  1);
        $this->model->addLang("10",
            "Pot de nachos sauce sweet chili",
            "",
            "2");

        $this->model->createArticle("11", "4",
            "Pot de nachos sauce guacamole",
            "",
            "5.00", "0", "", 2, 1,  1);
        $this->model->addLang("11",
            "Pot de nachos sauce guacamole",
            "",
            "2");

    }
}