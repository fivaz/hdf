<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 05.10.2018
 * Time: 10:04
 */

class IngredientController
{
    public $model;

    public function __construct()
    {
        $this->model = new IngredientModel();
    }

    public function loadIngredients($languageId, $articleId)
    {
        $ingredients = $this->model->getIngredientsByArticle($languageId, $articleId);
//        return $ingredients;
        return json_encode($ingredients);
    }

    public function attachIngredient($ingredientId, $articleId)
    {
        $ingredients = $this->model->attachIngredient($ingredientId, $articleId);
//        return $ingredients;
        return json_encode($ingredients);
    }

    public function detachIngredient($ingredientId, $articleId)
    {
        $ingredients = $this->model->detachIngredient($ingredientId, $articleId);
//        return $ingredients;
        return json_encode($ingredients);
    }

    public function selectIngredientName($ingredientName, $languageId)
    {
        $ingredients = $this->model->selectIngredientName($ingredientName, $languageId);
//        return $ingredients;
        return json_encode($ingredients);
    }



}