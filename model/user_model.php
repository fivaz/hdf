<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 16:01
 */

include_once("model.php");
/* Constante Bcrypt*/
define("CONST_BCRYPT_COST", 12); //takes significantly more time above 12


/* BCrypt --------------------------------------------------------------------------------- */
/***
 * fctBcryptHash : Return BCrypt hash of password
 * @param string $password
 * @return bool|string
 */
function fctBcryptHash($password)
{
    $bcryptOptions = [
        'cost' => CONST_BCRYPT_COST,
    ];

    return password_hash($password, PASSWORD_BCRYPT, $bcryptOptions); // BCRYPT Password hash
}

/***
 * @param $email
 * @return bool|mixed
 */
function fctUserFindEmail($email)
{

    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT * FROM USER where EMAIL= :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        $user = $sql->fetch(PDO::FETCH_ASSOC);

        if (!$user) {

            echo "Email/password not recognized";
            return false;
        }

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage()); //TODO
    }
    $db = NULL; // Close connection
    return $user;
}

function fctUserAdd($last_name, $first_name, $email, $password, $isActive)
{
    $passwordHash = fctBcryptHash($password);
    $email = strtolower($email);
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO USER (LAST_NAME, FIRST_NAME,EMAIL, PASSWORD_HASH, ISACTIVE) VALUES (:lastname,:firstname,:email,:password,:isActive)");
        $sql->bindParam(':lastname', $last_name, PDO::PARAM_STR);
        $sql->bindParam(':firstname', $first_name, PDO::PARAM_STR);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $sql->bindParam(':isActive', $isActive, PDO::PARAM_INT);
        $sql->execute();

        $lastUserId = $db->lastInsertId();


    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            //TODO ERROR HANDLING
            $error = -2;
            echo "email a double";
        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $lastUserId;
}

/***fctUserList: Return User list OR a given User from Id
 * @param int $id
 * @return array
 */


/***
 * @param $last_name
 * @param $first_name
 * @param $email
 * @param $password
 * @return int|string
 */


function fctUserEdit($user_id, $lastname, $firstname, $email, $privilege)
{
    try {
        $db = new myPDO();
        $sql = $db->prepare("UPDATE USER set LAST_NAME=:lastname, FIRST_NAME=:firstname, EMAIL=:email, PRIVILEGE=:privilege WHERE USER_ID=:user_id");
        $sql->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sql->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $sql->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':privilege', $privilege, PDO::PARAM_STR);
        $sql->execute();
        $lastUserId = $db->lastInsertId();

    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            $error = -2;
        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $lastUserId;
}


function fctUserEditDetails($user_id, $lastname, $firstname)
{
    try {
        $db = new myPDO();
        $sql = $db->prepare("UPDATE USER set LAST_NAME=:lastname, FIRST_NAME=:firstname WHERE USER_ID=:user_id");
        $sql->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sql->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $sql->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $sql->execute();
        $lastUserId = $db->lastInsertId();

    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            $error = -2;
        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $lastUserId;
}

/*** User : Frank Théodoloz
 * @param $userId
 * @param $password
 * @return int
 */
function fctUserEditPassword($userId, $password)
{
    $passwordHash = fctBcryptHash($password);
    try {
        $db = new myPDO();
        $sql = $db->prepare("UPDATE USER set PASSWORD_HASH=:password WHERE USER_ID=:user_id");
        $sql->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $sql->bindParam(':password', $passwordHash, PDO::PARAM_STR);

        $sql->execute();
        $result = $sql->rowCount();

    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            $error = -2;
        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $result;
}

function fctUserEditEmail($userId, $email)
{
    try {
        $db = new myPDO();
        $sql = $db->prepare("UPDATE USER set EMAIL=:email WHERE USER_ID=:user_id");
        $sql->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);

        $sql->execute();
        $result = $sql->rowCount();

    } catch (PDOException $e) {
        if (strpos($e->getMessage(), "Duplicate entry") || (strpos($e->getMessage(), "1062"))) {
            $error = -2;
        } else {
            die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
        }
        return $error;
    }
    $db = NULL; // Close connection
    return $result;
}

function fctUserList($user_id = 0)
{
    try {
        $db = new myPDO();

        if ($user_id > 0) {
            $sql = $db->prepare("SELECT * FROM USER WHERE USER_ID=:user_id");
            $sql->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        } else {
            $sql = $db->prepare("SELECT * FROM USER WHERE USER_ID > 0");
        }

        $sql->execute();
        $userList = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $userList;
}

function filterUser($privilege = 0)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT * FROM USER WHERE PRIVILEGE=:privilege AND USER_ID > 0");
        $sql->bindParam(':privilege', $privilege, PDO::PARAM_INT);

        $sql->execute();
        $userList = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $userList;
}

function fctUserIsActive($user_id, $isActive)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("Update USER SET ISACTIVE=:isActive where USER_ID=:user_id");
        $sql->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sql->bindParam(':isActive', $isActive, PDO::PARAM_INT);
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

function fctUserSetPrivilege($user_id, $hasPrivilege)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("Update USER SET PRIVILEGE=$hasPrivilege where USER_ID=:user_id");
        $sql->bindParam(':user_id', $user_id, PDO::PARAM_INT);
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
 * fctInsertAnonymousUser: Clear User table and insert Anonymous user with ID 0
 */
function fctInsertZeroIdUser()
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

function clearUserDatabase()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM USER; ALTER TABLE USER AUTO_INCREMENT=1");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}


/***
 * fctDemoData
 */
function fctInsertUserDemoData()
{

    clearUserDatabase();

//    fctUserAdd("lastname", "firstname", "email", "password");
//    fctUserFindEmail("mail");
//    var_dump(fctUserList(1));
//    fctUserAdd("Cabrera", "Daniel", "dakany12@gmail.com", "d");
//    fctUserAdd("Cabrera", "j", "dakany12@gmail.com", "f");
//    fctUserEditDetails(1, "CCCCCC", "DDDD", "e@gmail.com");
//    fctUserEditPassword("bob");
//
//    var_dump(fctUserList(1));
//    var_dump(fctUserList(2));
//    fctUserDisable(1);
//    var_dump(fctUserList());
//    fctUserEditDetails(2,"Cabrera","Daniele","dakany12@gmail.com");
    fctUserAdd("Cabrera", "Daniel", "dan.cabrera12@gmail.com", "daniel", 1);
    fctUserAdd("Théodoloz", "Frank", "frank@gmail.com", "frank", 1);
    fctUserAdd("Fivaz", "Stefane", "stefan@gmail.com", "stefane", 1);
    fctUserAdd("Mahesalingam", "Mithul", "mithul@gmail.com", "mithul", 1);
    fctUserAdd("Bayat", "Alexandre", "alexbaya@gmail.com", "alexbaya", 1);
    fctUserAdd("Quinlan", "Patrick", "patrick@gmail.com", "patrick", 1);
    fctUserAdd("De Banoff", "Alexandre", "alexdeban@gmail.com", "alexdeban", 1);
}

//fctInsertUserDemoData();
//fctUserEditDetails(2,"Cabrera1","Daniele","dakany12@gmail.com");
//fctUserEditEmail(1, "danny@gmail.com");

