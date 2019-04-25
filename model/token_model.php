<?php
/**
 * Created by PhpStorm.
 * User: THEODOLOZ_FRANK-ESIG
 * Date: 18.10.2018
 * Time: 14:10
 */

include_once('model.php');

/***fctTokenAdd: Creates and returns a Token
 * @param $action
 * @param $email
 * @param $value
 * @return int|string
 */
function fctTokenAdd($action, $email, $value = NULL)
{
    //Generate a random string.
    $token = openssl_random_pseudo_bytes(32);
    //Convert the binary data into hexadecimal representation.
    $token = bin2hex($token);

    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO TOKEN (TOKEN,TYPE,VALUE,DATETIME) VALUES (:token,:type,:value,now())");
        $sql->bindParam(':token', $token, PDO::PARAM_STR);
        $sql->bindParam(':type', $action, PDO::PARAM_STR);
        $sql->bindParam(':value', $email, PDO::PARAM_STR);
//        $sql->bindParam(':id', $id, PDO::PARAM_INT);
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
    return $token;
}

/***fctTokenDelete: Removes a Token once used
 * @param $token
 * @return int
 */
function fctTokenDelete($token)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM TOKEN WHERE TOKEN = :token");
        $sql->bindParam(':token', $token, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->rowCount();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctTokenDetail: Return a Token details
 * @param $token
 * @return mixed
 */
function fctTokenDetail($token)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT * FROM TOKEN WHERE TOKEN = :token");
        $sql->bindParam(':token', $token, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

//A mettre dans feedback_model :
/***fctFeedbackEmailFind: Returns if a user email is already confirmed
 * @param $email
 * @return mixed
 */
function fctFeedbackEmailFind($email)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT count(USER_ID) FROM FEEDBACK WHERE EMAIL = :email and CONFIRMED = 1");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->fetchColumn();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctFeedbackEmailConfirm: Set feedback status as confirmed
 * @param $id
 * @return int
 */
function fctFeedbackEmailConfirm($id) //TODO copy the query below in feedback_model
{
//    include_once('../model/feedback_model.php');
//    fctFeedbackSetConfirmed($id);

    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE FEEDBACK SET CONFIRMED = 1 WHERE FEED_ID = :id");
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->rowCount();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctUserEmailConfirm: Activate the user account
 * @param $id
 * @return int
 */
function fctUserEmailConfirm($id)
{
    include_once('../model/user_model.php');
    $result = fctUserIsActive($id, 1);
    return $result;
}

/***fctUserEmailChange: Changes the User email
 * @param $userId
 * @param $email
 * @return int
 */
function fctUserEmailChange($userId, $email) //TODO move this query in user_model
{
//    include_once('../model/user_model.php');

    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE USER SET EMAIL = :email WHERE USER_ID = :userId");
        $sql->bindParam(':userId', $userId, PDO::PARAM_INT);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->rowCount();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctContactEmailConfirm: Updates the Contact email on
 * @param $email
 * @return int
 */
function fctContactEmailConfirm($email)
{
    include_once('../model/parameter_model.php');
    $result = fctParameterContactEmailChange($email);
    return $result;

}
