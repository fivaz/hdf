<?php
/**
 * Created by PhpStorm.
 * User: MAHESALINGAM_MI-ESIG
 * Date: 28.09.2018
 * Time: 09:21
 */

include_once('model.php');


/*** fctFeedbackAdd: Insert a new Feedback and return lastInsertId()
 * @param $userId
 * @param $full_name
 * @param $title
 * @param $note
 * @param $message
 * @param $email
 * @return int|string
 */
//function fctFeedbackAdd($userId, $title, $full_name, $note, $message, $email, $published)
function fctFeedbackAdd($userId, $full_name, $title, $note, $message, $email)
{
    if ($userId > 0) { //on connait l'utilisateur
        $confirmed = 1;
    } else {
        $confirmed = 0;
    }

    try {
        $db = new myPDO();

        if (!$userId) {
            $sql = $db->prepare("INSERT INTO FEEDBACK (DATETIME,USER_ID,TITLE,FULL_NAME,NOTE,MESSAGE,EMAIL,CONFIRMED,PUBLISHED) VALUES (now(),0, :title,:full_name,:note,:message,:email,:confirmed,:published)");

        } else {
    $sql = $db->prepare("INSERT INTO FEEDBACK (DATETIME,USER_ID,TITLE,FULL_NAME,NOTE,MESSAGE,EMAIL,CONFIRMED,PUBLISHED) VALUES (now(), :user, :title, :full_name, :note, :message, :email, :confirmed, :published)");
//            $sql = $db->prepare("INSERT INTO FEEDBACK (DATETIME,TITLE,FULL_NAME,NOTE,MESSAGE,EMAIL,CONFIRMED,PUBLISHED) VALUES (now(), :title, :full_name, :note, :message, :email, :confirmed, :published)");
            $sql->bindParam(':user', $userId, PDO::PARAM_INT);
        }
//        $sql->bindParam(':datetime', $datetime, PDO::PARAM_STR);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
        $sql->bindParam(':full_name', $full_name, PDO::PARAM_STR);
        $sql->bindParam(':note', $note, PDO::PARAM_INT);
        $sql->bindParam(':message', $message, PDO::PARAM_STR);
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->bindParam(':confirmed', $confirmed, PDO::PARAM_STR);
        $sql->bindParam(':published', $published, PDO::PARAM_STR);

//        var_dump($sql);
        $sql->execute();

        $lastFeedbackId = $db->lastInsertId();

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
    return $lastFeedbackId;
}


/*** fctGroupDelete: Delete a Feedback and return rowCount()
 * @param $feedbackId
 * @return int
 */
function fctFeedbackDelete($feedbackId)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM FEEDBACK WHERE FEED_ID = :feed_id");
        $sql->bindParam(':feed_id', $feedbackId, PDO::PARAM_INT);
        $sql->execute();
        $result = $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctFeedbackList: Return a List of Feedback OR a given Feedback
 * @param int $feedbackId
 * @return array
 */
function fctFeedbackList($feedbackId = 0)
{
    try {
        $db = new myPDO();

        if ($feedbackId > 0) {
            $sql = $db->prepare("SELECT * FROM FEEDBACK WHERE FEED_ID =:feed_id ");
            $sql->bindParam(':feed_id', $feedbackId, PDO::PARAM_INT);

        } else {
            $sql = $db->prepare("SELECT * FROM FEEDBACK");
        }

        $sql->execute();
        $Feedbacks = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $Feedbacks;
}

/***fctSetFeedbackPublished: Set/unset published status of feedback
 * @param $feedbackId
 * @param $published
 */
function fctFeedbackSetPublished($feedbackId, $published){
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE FEEDBACK SET PUBLISHED = $published WHERE FEED_ID = $feedbackId");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}


/***
 * clearDatabase: clear content of db
 */
function clearFeedbackDatabase()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM FEEDBACK; ALTER TABLE FEEDBACK AUTO_INCREMENT=1");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * fctInsertDemoData: Test and demo data
 */
function fctInsertFeedbackDemoData()
{
//    clearFeedbackDatabase();

    fctFeedbackAdd(1, "Dupont Paul", "Bravo !", 5, "Très bon produits !", "dupont@gmail.com"); //1
    fctFeedbackAdd(0, "Kant Anthony", "Mauvais !", 1, "Prix chers et produits pas frais !", "kant@gmail.com");
    fctFeedbackAdd(0, "Curtet Jean", "Bon", 3, "savoureux, mais les prix sont un peu élevés.", "curtet@gmail.com"); //1
//    fctFeedbackAdd(); //2
//    fctFeedbackAdd(); //3
//    var_dump(fctFeedbackList(NULL));
//    fctFeedbackEdit();
//   fctFeedbackDelete(0);
//    var_dump(fctFeedbackList());
//    echo "1:";
//    var_dump(fctFeedbackList());

}

//fctInsertFeedbackDemoData();