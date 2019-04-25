<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 05.10.2018
 * Time: 10:04
 */

class CategoryController
{
    public $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function loadCategories($languageId)
    {
//        $categories = $this->model->selectJoin($languageId);
        $categories = $this->model->selectJoinOrdered($languageId);
        return json_encode($categories);
    }

    public function createCategory($name, $price, $languageId)
    {
        $this->model->setAttr("PRICE", $price);
        $this->model->langModel->setAttr("NAME", $name);
        $this->model->langModel->setAttr("LANG_ID", $languageId);

        $nextPosition = $this->model->getNextPosition();

        $this->model->setAttr("POSITION", $nextPosition);
        $this->model->create();
        $id = $this->model->getId();
        $category = $this->model->selectJoin($languageId, $id);
        return json_encode($category);
    }

    public function getCategoriesName($languageId){
        $categoriesName = array();
        $categories = $this->model->selectJoin($languageId);
        foreach ($categories as $category){
           array_push($categoriesName, $category['NAME']);
        }
        return json_encode($categoriesName);
    }

    public function editCategory($name, $price, $id, $languageId)
    {
        $this->model->find($id);
        $this->model->setAttr("PRICE", $price);
        $this->model->langModel->setAttr("CATE_ID", $id);
        $this->model->langModel->setAttr("NAME", $name);
        $this->model->langModel->setAttr("LANG_ID", $languageId);
        $result = $this->model->update();
        return json_encode($result);
    }

    public function deleteCategory($id){
        $results = array();

        $result = $this->model->langModel->delete($id);
        array_push($results, $result);

        $result = $this->model->delete($id);
        array_push($results, $result);

        return json_encode($results);
    }

    public function changeLanguage($languageId, $id){
        $result = $this->model->selectJoin($languageId, $id);
        if($result)
        {
            return json_encode($result);
        }
        else
        {
            $this->model->langModel->setAttr($this->model->columnId, $id);
            $this->model->langModel->setAttr("LANG_ID", $languageId);
            //return create to check errors
            $this->model->langModel->create();
            //var_dump($result);
            $result = $this->model->selectJoin($languageId, $id);
            return json_encode($result);
        }
    }

    public function updatePosition($id, $newPosition){
        $category = $this->model->find($id);
        $category->setAttr("POSITION", $newPosition);
        return json_encode($category->update());
    }

    public function deleteAll()
    {
        return $this->model->deleteAll();
    }

    public function seed()
    {
        $results = array();
        $result = $this->model->createCategory("1", "THE HOT DOG FR", "", "1", "1");
        array_push($results, $result);
        $result = $this->model->addLang("1", "THE HOT DOG EN", "2");
        array_push($results, $result);
        $result = $this->model->createCategory("3", "THE DRINKS", "", "2", "1");
        array_push($results, $result);
        $result = $this->model->addLang("3", "THE DRINKS", "2");
        array_push($results, $result);
        $result = $this->model->createCategory("2", "THE DESSERT", "", "3", "1");
        array_push($results, $result);
        $result = $this->model->addLang("2", "THE DESSERT", "2");
        array_push($results, $result);
        $result = $this->model->createCategory("4", "THE EXTRA", "", "4", "1");
        array_push($results, $result);
        $result = $this->model->addLang("4", "THE EXTRA", "2");
        array_push($results, $result);
        return $results;
    }

}