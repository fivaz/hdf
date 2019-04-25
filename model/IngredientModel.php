<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 04.10.2018
 * Time: 17:18
 */

class IngredientModel extends MainModel
{

    public function __construct()
    {
        $this->table = "INGREDIENT";
        $this->columnId = "INGR_ID";
        $this->langModel = new IngrLangModel();
        $this->tableLang = "INGR_LANG_TEXT";
        parent::__construct();
    }

    public function getIngredientsByArticle($languageId, $articleId)
    {
        $query = "SELECT * FROM INGREDIENT
        JOIN INGR_LANG_TEXT 
        ON INGREDIENT.INGR_ID = INGR_LANG_TEXT.INGR_ID 
        JOIN MENU_INGR_MAPPING 
        ON MENU_INGR_MAPPING.INGR_ID = INGREDIENT.INGR_ID 
        AND INGR_LANG_TEXT.LANG_ID = {$languageId}
        WHERE MENU_INGR_MAPPING.MENU_ID = {$articleId}";

//        echo $query;

        $elementsSQL = $this->connection->query($query);

        $elements = $elementsSQL->fetchAll();

        return $this->filterResults($elements);
    }

    public function attachIngredient($ingredientId, $articleId)
    {
        $query = "INSERT INTO MENU_INGR_MAPPING VALUES ({$ingredientId},{$articleId})";

        echo $query;

        $result = $this->connection->exec($query);

        return $result;
    }

    public function detachIngredient($ingredientId, $articleId)
    {
        $query = "DELETE FROM MENU_INGR_MAPPING WHERE INGR_ID = {$ingredientId} AND MENU_ID = {$articleId}";

        echo $query;

        $result = $this->connection->exec($query);

        return $result;
    }

    public function selectIngredientName($ingredientName, $languageId)
    {
        $query = "SELECT INGREDIENT.*, MENU_INGR_MAPPING.*, INGR_LANG_TEXT.*, INGREDIENT.INGR_ID AS INGR_ID
        FROM INGREDIENT
        LEFT JOIN INGR_LANG_TEXT ON INGREDIENT.INGR_ID = INGR_LANG_TEXT.INGR_ID
        LEFT JOIN MENU_INGR_MAPPING ON INGREDIENT.INGR_ID = MENU_INGR_MAPPING.INGR_ID
        WHERE INGR_LANG_TEXT.LANG_ID = {$languageId} AND INGR_LANG_TEXT.NAME LIKE '{$ingredientName}%' AND MENU_INGR_MAPPING.MENU_ID IS NULL";

//        echo $query;

        $elementsSQL = $this->connection->query($query);

        $elements = $elementsSQL->fetchAll();

        return $this->filterResults($elements);
    }

}