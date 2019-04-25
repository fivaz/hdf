<?php
/**
 * Parameter model
 * User: Frank Théodoloz
 * Date: 25.09.2018
 * Time: 09:29
 */

include_once('model.php');

/***fctParameterAdd: Insert a new Parameter and return lastInsertId()
 * @param $langId
 * @param $name
 * @param $value
 * @return int|string
 */
function fctParameterAdd($langId, $name, $value)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO PARAMETER VALUES (DEFAULT)");
        $sql->execute();

        $lastParameterId = $db->lastInsertId();

        $sql = $db->prepare("INSERT INTO PARA_LANG_TEXT (PARA_ID, LANG_ID, NAME, VALUE) VALUES (:para_id, :lang_id, :name, :value)");
        $sql->bindParam(':para_id', $lastParameterId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $langId, PDO::PARAM_INT);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':value', $value, PDO::PARAM_STR);
        $sql->execute();

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
    return $lastParameterId;
}

/***fctParameterTranslateAdd: Add a translation of an Parameter and return rowCount()
 * @param $parameterId
 * @param $languageId
 * @param $name
 * @param $value
 * @return int
 */
function fctParameterTranslateAdd($parameterId, $languageId, $name, $value)
{
    try {
        $db = new myPDO();


        $sql = $db->prepare("INSERT INTO PARA_LANG_TEXT (PARA_ID, LANG_ID, NAME, VALUE) VALUES (:para_id, :lang_id, :name, :value)");
        $sql->bindParam(':para_id', $parameterId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':value', $value, PDO::PARAM_STR);
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

/***fctParameterEdit: Edit an Parameter and return rowCount()
 * @param $parameterId
 * @param $languageId
 * @param $name
 * @param $value
 * @return int
 */
function fctParameterEdit($name, $value, $languageId = 1)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE PARA_LANG_TEXT SET VALUE= :value WHERE NAME = :name AND LANG_ID = :lang_id");
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':value', $value, PDO::PARAM_STR);
        $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
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

function fctParameterContactEmailChange($email)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE PARA_LANG_TEXT SET VALUE = :email WHERE NAME = 'CONTACT_EMAIL'");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
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




/***fctParameterDelete: Delete an Parameter and return rowCount()
 * @param $parameterId
 * @return int
 */
function fctParameterDelete($parameterId)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM PARA_LANG_TEXT WHERE PARA_ID = :para_id");
        $sql->bindParam(':para_id', $parameterId, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->rowCount();

        $sql = $db->prepare("DELETE FROM PARAMETER WHERE PARA_ID = :para_id");
        $sql->bindParam(':para_id', $parameterId, PDO::PARAM_INT);
        $sql->execute();

        $result += $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctParameterList: Return a List of Parameters OR a given Parameter
 * @param int $parameterId default=0 (All)
 * @param int $langId default=1 (Francais)
 * @return array
 */
function fctParameterList($parameterId = 0, $langId = 1)
{
    try {
        $db = new myPDO();

        if ($parameterId > 0) {
            $sql = $db->prepare("SELECT * FROM PARAMETER p JOIN PARA_LANG_TEXT l ON l.PARA_ID = p.PARA_ID WHERE p.PARA_ID = :parameter_id AND l.LANG_ID = :lang_id");
            $sql->bindParam(':parameter_id', $parameterId, PDO::PARAM_INT);
            $sql->bindParam(':lang_id', $langId, PDO::PARAM_INT);
        } else {
            $sql = $db->prepare("SELECT * FROM PARAMETER p JOIN PARA_LANG_TEXT l ON l.PARA_ID = p.PARA_ID ORDER BY p.PARA_ID");
        }

        $sql->execute();
        $groupList = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $groupList;
}

function fctParameterLogoUpdate($image)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE PARA_LANG_TEXT SET VALUE = :logo WHERE NAME = 'COMPANY_LOGO'");
        $sql->bindParam(':logo', $image, PDO::PARAM_LOB);
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

function fctParameterGet($parameterName)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT VALUE FROM PARAMETER p JOIN PARA_LANG_TEXT l ON l.PARA_ID = p.PARA_ID WHERE NAME = :name");
        $sql->bindParam(':name', $parameterName, PDO::PARAM_STR);
        $sql->execute();

        $parameter = $sql->fetchColumn();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection

    return $parameter;
}


/***
 * clearDatabase: clear content of db
 */
function clearParameterDatabase()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM PARA_LANG_TEXT");
        $sql->execute();
        $sql = $db->prepare("DELETE FROM PARAMETER; ALTER TABLE PARAMETER AUTO_INCREMENT=1");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * fctInsertAnonymousUser: Clear User table and insert Anonymous user with ID 0
 */
function fctInsertAnonymousUser()
{
    try {
        $db = new myPDO();
        $db->exec('SET SESSION SQL_MODE ="NO_AUTO_VALUE_ON_ZERO"');
        $sql = $db->prepare("INSERT INTO USER (USER_ID, LAST_NAME) VALUE (0,'Anonymous')");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}


/***
 * ClearLanguageDatabase
 */
function clearLanguageDatabase()
{
    try {
        $db = new myPDO();
        $sql = $db->prepare("DELETE FROM LANGUAGE; ALTER TABLE LANGUAGE AUTO_INCREMENT=1");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * fctInsertLanguages: Clear language table and insert FR + EN
 */
function fctInsertLanguages()
{
    try {
        $db = new myPDO();
        $sql = $db->prepare("INSERT INTO LANGUAGE (LANGUAGE) VALUE ('FR')");
        $sql->execute();
        $sql = $db->prepare("INSERT INTO LANGUAGE (LANGUAGE) VALUE ('EN')");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * fctInsertDemoData: Test and demo data
 */
function fctInsertParameterDemoData()
{
    fctInsertLanguages();
    fctInsertAnonymousUser();
    clearParameterDatabase();

// tests
//    fctParameterAdd(1, "FR nom 1", "FR valeur 1");
//    fctParameterTranslateAdd(1, 2, "EN name 1", "EN value 1");
//    fctParameterAdd(1, "FR nom 2", "FR valeur 2");
//    echo "liste (3)";
//    var_dump($parameters = fctParameterList(0, 1));
//    fctParameterEdit( "FR description change", "FR titre change");
//    fctParameterDelete(2);
//    echo "liste (2)";
//    var_dump($parameters = fctParameterList(0, 1));
//    echo "liste (1)";
//    var_dump($parameters = fctParameterList(1));

}

//fctInsertParameterDemoData();