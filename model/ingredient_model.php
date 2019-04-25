<?php
/**
 * Created by PhpStorm.
 * User: MAHESALINGAM_MI-ESIG
 * Date: 28.09.2018
 * Time: 09:21
 */

include_once('model.php');

/*** fctIngredientAdd: Insert a new Ingredient and return lastInsertId()
 * @param $languageId
 * @param $description
 * @param $title
 * @param $address
 * @return int|string
 */
function fctIngredientAdd($languageId, $name)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO INGREDIENT VALUES (DEFAULT)");
        $sql->execute();

        $lastIngredientId = $db->lastInsertId(); //id de l'ingr

        $sql = $db->prepare("INSERT INTO INGR_LANG_TEXT (INGR_ID, LANG_ID, NAME) VALUES (:ingr_id, :lang_id, :name)");
        $sql->bindParam(':ingr_id', $lastIngredientId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->execute();

        // ajout intolérance de l'aliment en lui-meme

//        $sql = $db->prepare("INSERT INTO FOODINTOLERANCE VALUES (DEFAULT)");
//        $sql->execute();
//
//        $lastFoodId = $db->lastInsertId(); //id de l'into


//        $sql = $db->prepare("INSERT INTO FOOD_LANG_TEXT (FOOD_ID, LANG_ID, NAME) VALUES (:food_id, :lang_id, :name)");
//        $sql->bindParam(':food_id', $lastFoodId, PDO::PARAM_INT);
//        $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
//        $sql->bindParam(':name', $name, PDO::PARAM_STR);
//        $sql->execute();


//        // lisiaon ingrédient à intolérance de l'aliment en lui-meme
//        fctIngredientIntoAdd($lastIngredientId,$lastFoodId);



    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            //TODO ERROR HANDLING
            $error = -2;

        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $lastIngredientId;
}

//function fctIngredientIntoAdd($lastIngredientId, $foodId)
//{
//    //ajout de l'ingré a l'into-allergie (regroupement)
//    try {
//        $db = new myPDO();
//
//        $sql = $db->prepare("INSERT INTO INGREDIENTINTOLERANCE (INGR_ID, FOOD_ID) VALUES (:ingr_id, :food_id)");
//        $sql->bindParam(':ingr_id', $lastIngredientId, PDO::PARAM_INT);
//        $sql->bindParam(':food_id', $foodId, PDO::PARAM_INT);
//        $sql->execute();
//
//        $result = $sql->rowCount();
//
//
//    } catch (PDOException $e) {
//        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
//            //TODO ERROR HANDLING
//            $error = -2;
//
//        } else {
//            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
//        }
//        return $error;
//    }
//    $db = NULL; // Close connection
//    return $result;
//}

/*** fctIngredientEdit: Edit a Ingredient and return rowCount()
 * @param $ingredientId
 * @param $languageId
 * @param $description
 * @param $title
 * @param $address
 * @return int
 */
function fctIngredientEdit($ingredientId, $languageId, $name)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE INGR_LANG_TEXT SET NAME = :name WHERE INGR_ID = :ingr_id AND LANG_ID = :lang_id");
        $sql->bindParam(':ingr_id', $ingredientId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->rowCount();

    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            //TODO ERROR HANDLING
            $error = -2;

        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $result;
}

/*** fctGroupDelete: Delete a Ingredient and return rowCount()
 * @param $ingredientId
 * @return int
 */
function fctIngredientDelete($ingredientId)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM INGR_LANG_TEXT WHERE INGR_ID = :ingr_id");
        $sql->bindParam(':ingr_id', $ingredientId, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->rowCount();

        $sql = $db->prepare("DELETE FROM INGREDIENT WHERE INGR_ID = :ingr_id");
        $sql->bindParam(':ingr_id', $ingredientId, PDO::PARAM_INT);
        $sql->execute();

        $result += $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctIngredientList: Return a List of Ingredient OR a given Ingredient
 * @param int $ingredientId
 * @param int $languageId
 * @return array
 */

function getIngredient($languageId, $ingredientId)
{
    $ingredient = fctIngredientList($languageId, $ingredientId);
    if(!$ingredient){
        fctIngredientTranslateAdd($ingredientId, $languageId, "");
        $ingredient = fctIngredientList($languageId, $ingredientId);
    }
    return $ingredient;
}

function fctIngredientList($languageId = 1, $ingredientId = 0)
{
    try {
        $db = new myPDO();

        if ($ingredientId > 0) {
            $sql = $db->prepare("SELECT * FROM INGREDIENT e JOIN INGR_LANG_TEXT l ON l.INGR_ID = e.INGR_ID WHERE e.INGR_ID =:ingr_id AND l.LANG_ID = :lang_id");
            $sql->bindParam(':ingr_id', $ingredientId, PDO::PARAM_INT);
            $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
            // $ingredientCherchée[0].['TITLE']
        } else {
            $sql = $db->prepare("SELECT * FROM INGREDIENT e JOIN INGR_LANG_TEXT l ON l.INGR_ID = e.INGR_ID WHERE l.LANG_ID = :lang_id ORDER BY e.INGR_ID");
            $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
        }

        $sql->execute();
        $Ingredients = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $Ingredients;
}

/*** fctIngredientTranslateAdd : translate the ingredient
 * @param $ingredientId
 * @param $languageId
 * @param $description
 * @param $title
 * @return int
 */

function fctIngredientTranslateAdd($ingredientId, $languageId, $name)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO INGR_LANG_TEXT (INGR_ID, LANG_ID, NAME) VALUES (:ingr_id, :lang_id, :name)");
        $sql->bindParam(':ingr_id', $ingredientId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->rowCount();
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            //TODO ERROR HANDLING
            $error = -2;

        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $result;
}


/***
 * clearDatabase: clear content of db
 */
function clearIngredientDatabase()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM INGR_LANG_TEXT");
        $sql->execute();

        $sql = $db->prepare("DELETE FROM MENU_INGR_MAPPING");
        $sql->execute();
        $sql = $db->prepare("DELETE FROM INGREDIENT; ALTER TABLE INGREDIENT AUTO_INCREMENT=1");
        $sql->execute();


    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * fctInsertDemoData: Test and demo data
 */
function fctInsertIngredientDemoData()
{
//   clearIngredientDatabase();
//    echo "Database clear !<br/>";
    fctIngredientAdd(1, "Jambon");
    fctIngredientAdd(1, "Lait");
    fctIngredientAdd(1, "Cacahuète");
    fctIngredientAdd(1, "Pain");
    fctIngredientAdd(1, "Saucisse");
    echo "Add success !<br/>";
//    fctIngredientEdit(1, 1, "Lait");
//    echo "Edit success !<br/>";
//    fctIngredientTranslateAdd(1, 2, "Milk");
//    echo "Translation success !<br/>";
//    var_dump(fctIngredientList(1));

}
//fctInsertIngredientDemoData();