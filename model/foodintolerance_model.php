<?php
/**
 * Created by PhpStorm.
 * User: MAHESALINGAM_MI-ESIG
 * Date: 28.09.2018
 * Time: 14:19
 */

include_once('model.php');
//TODO : Contrainte nom unique

/*** fctFoodintoleranceAdd: Insert a new Foodintolerance and return lastInsertId()
 * @param $languageId
 * @param $description
 * @param $name
 */
function fctFoodintoleranceAdd($languageId, $name)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO FOODINTOLERANCE VALUES (DEFAULT)");
        $sql->execute();

        $lastFoodintoleranceId = $db->lastInsertId();

        $sql = $db->prepare("INSERT INTO FOOD_LANG_TEXT (FOOD_ID, LANG_ID, NAME) VALUES (:food_id, :lang_id, :fname)");
        $sql->bindParam(':food_id', $lastFoodintoleranceId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
        $sql->bindParam(':fname', $name, PDO::PARAM_STR);
        $sql->execute();
        echo "Successfull !";

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
    return $lastFoodintoleranceId;
}

/*** fctFoodintoleranceEdit: Edit a Foodintolerance and return rowCount()
 * @param $foodintoleranceId
 * @param $languageId
 * @param $name
 * @return int
 */
function fctFoodintoleranceEdit($foodintoleranceId, $languageId, $name)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE FOOD_LANG_TEXT SET NAME = :name WHERE FOOD_ID = :food_id AND LANG_ID = :lang_id");
        $sql->bindParam(':food_id', $foodintoleranceId, PDO::PARAM_INT);
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

/*** fctGroupDelete: Delete a Foodintolerance and return rowCount()
 * @param $foodintoleranceId
 * @return int
 */
function fctFoodintoleranceDelete($foodintoleranceId)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM FOOD_LANG_TEXT WHERE FOOD_ID = :food_id");
        $sql->bindParam(':food_id', $foodintoleranceId, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->rowCount();

        $sql = $db->prepare("DELETE FROM FOODINTOLERANCE WHERE FOOD_ID = :food_id");
        $sql->bindParam(':food_id', $foodintoleranceId, PDO::PARAM_INT);
        $sql->execute();

        $result += $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctFoodintoleranceList: Return a List of Foodintolerance OR a given Foodintolerance
 * @param int $foodintoleranceId
 * @param int $languageId
 * @return array
 */
function fctFoodintoleranceList( $languageId = 1, $foodintoleranceId = 0)
{
    try {
        $db = new myPDO();

        if ($foodintoleranceId > 0) {
            $sql = $db->prepare("SELECT * FROM FOODINTOLERANCE e JOIN FOOD_LANG_TEXT l ON l.FOOD_ID = e.FOOD_ID WHERE e.FOOD_ID =:food_id AND l.LANG_ID = :lang_id  ");
            $sql->bindParam(':food_id', $foodintoleranceId, PDO::PARAM_INT);
            $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
        } else {
            $sql = $db->prepare("SELECT * FROM FOODINTOLERANCE e JOIN FOOD_LANG_TEXT l ON l.FOOD_ID = e.FOOD_ID ORDER BY e.FOOD_ID");
        }

        $sql->execute();
        $Foodintolerances = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $Foodintolerances;
}

/*** fctFoodintoleranceTranslateAdd : translate the foodintolerance
 * @param $foodintoleranceId
 * @param $languageId
 * @param $name
 * @return int
 */

function fctFoodintoleranceTranslateAdd($foodintoleranceId, $languageId, $name)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO FOOD_LANG_TEXT (FOOD_ID, LANG_ID, NAME) VALUES (:food_id, :lang_id, :name)");
        $sql->bindParam(':food_id', $foodintoleranceId, PDO::PARAM_INT);
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
function clearFoodIntoDatabase()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM FOOD_LANG_TEXT");
        $sql->execute();
        $sql = $db->prepare("DELETE FROM FOODINTOLERANCE; ALTER TABLE FOODINTOLERANCE AUTO_INCREMENT=1");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * fctInsertDemoData: Test and demo data
 */
function fctInsertFoodIntoDemoData()
{
//    clearFoodIntoDatabase();
    fctFoodintoleranceAdd(1,"Lactose");
    fctFoodintoleranceAdd(1,"Gluten");
    fctFoodintoleranceAdd(1,"Arachides");
    fctFoodintoleranceAdd(1,"Cornichons");
    fctFoodintoleranceAdd(1,"Oignons");
    echo "success";
//    fctFoodintoleranceTranslateAdd(1, 2, "LactoseEN"); //1
//    fctFoodintoleranceAdd(1, "Gluten"); //2
//    fctFoodintoleranceAdd(1, "Arachides"); //3
//    fctFoodintoleranceList();
//    fctFoodintoleranceEdit(1, 1, "Lactose1.1");
//    fctFoodintoleranceDelete(2);
// var_dump(fctFoodintoleranceList(1));
//    echo "1:";
//    var_dump(fctFoodintoleranceList(3));

}

//fctInsertFoodIntoDemoData();

