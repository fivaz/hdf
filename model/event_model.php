<?php
/**
 * Event model
 * User: Frank Théodoloz
 * Date: 25.09.2018
 * Time: 09:29
 */

include_once('model.php');
include_once ('calendar_model.php');

/*** fctEventAdd: Insert a new Event and return lastInsertId()
 * @param $langId
 * @param $title
 * @param $description
 * @param $address
 * @param $link
 * @param $image
 * @return int|string
 */
function fctEventAdd($langId, $title, $description, $address, $link, $image)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO EVENT (ADDRESS, LINK, IMAGE) VALUES (:address, :link, :image)");
        $sql->bindParam(':address', $address, PDO::PARAM_STR);
        $sql->bindParam(':link', $link, PDO::PARAM_STR);
        $sql->bindParam(':image', $image, PDO::PARAM_STR);
        $sql->execute();

        $lastEventId = $db->lastInsertId();

        $sql = $db->prepare("INSERT INTO EVEN_LANG_TEXT (EVEN_ID, LANG_ID, TITLE, DESCRIPTION) VALUES (:even_id, :lang_id, :title, :description)");
        $sql->bindParam(':even_id', $lastEventId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $langId, PDO::PARAM_INT);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
        $sql->bindParam(':description', $description, PDO::PARAM_STR);
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
    return $lastEventId;
}

/***fctEventTranslateAdd: Add a translation of an Event and return rowCount()
 * @param $eventId
 * @param $langId
 * @param $title
 * @param $description
 * @return int
 */
function fctEventTranslateAdd($eventId, $langId, $title, $description)
{
    try {
        $db = new myPDO();


        $sql = $db->prepare("INSERT INTO EVEN_LANG_TEXT (EVEN_ID, LANG_ID, TITLE, DESCRIPTION) VALUES (:event_id, :lang_id, :title, :description)");
        $sql->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $langId, PDO::PARAM_INT);
        $sql->bindParam(':description', $description, PDO::PARAM_STR);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
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

/*** fctEventEdit: Edit an Event and return rowCount()
 * @param $eventId
 * @param $langId
 * @param $description
 * @param $title
 * @param $address
 * @param $link
 * @return int
 */
function fctEventEdit($eventId, $langId, $title, $description, $address, $link)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE EVENT SET ADDRESS = :address, LINK = :link WHERE EVEN_ID = :event_id");
        $sql->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $sql->bindParam(':address', $address, PDO::PARAM_STR);
        $sql->bindParam(':link', $link, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->rowCount();

        $sql = $db->prepare("UPDATE EVEN_LANG_TEXT SET TITLE = :title, DESCRIPTION = :description WHERE EVEN_ID = :event_id AND LANG_ID = :lang_id");
        $sql->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $langId, PDO::PARAM_INT);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
        $sql->bindParam(':description', $description, PDO::PARAM_STR);
        $sql->execute();

        $result += $sql->rowCount();

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

/*** fctEventEdit: Edit an Event and return rowCount()
 * @param $eventId
 * @param $image
 * @return int
 */
function fctEventEditImage($eventId, $image)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE EVENT SET IMAGE = :image WHERE EVEN_ID = :event_id");
        $sql->bindParam(':event_id', $eventId, PDO::PARAM_STR);
        $sql->bindParam(':image', $image, PDO::PARAM_STR);
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

/*** fctEventDelete: Delete an Event and return rowCount()
 * @param $eventId
 * @return int
 */
function fctEventDelete($eventId)
{
    $result = fctCalendarEventDelete($eventId);

    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM EVEN_LANG_TEXT WHERE EVEN_ID = :event_id");
        $sql->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $sql->execute();

        $sql = $db->prepare("DELETE FROM EVENT WHERE EVEN_ID = :event_id");
        $sql->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $sql->execute();

        $result += $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctEventList: Return a List of Events OR a given Event
 * @param int $langId default=1 (Francais)
 * @param int $eventId default=0 (All)
 * @return array
 */
function fctEventList($langId = 1, $eventId = 0)
{
    try {
        $db = new myPDO();

        if ($eventId > 0) {
            $sql = $db->prepare("SELECT * FROM EVENT e JOIN EVEN_LANG_TEXT l ON l.EVEN_ID = e.EVEN_ID WHERE e.EVEN_ID = :event_id AND l.LANG_ID = :lang_id");
            $sql->bindParam(':lang_id', $langId, PDO::PARAM_INT);
            $sql->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $sql->execute();
            $result = $sql->fetchColumn();
        } else {
            $sql = $db->prepare("SELECT * FROM EVENT e JOIN EVEN_LANG_TEXT l ON l.EVEN_ID = e.EVEN_ID WHERE l.LANG_ID = :lang_id ORDER BY e.EVEN_ID");
            $sql->bindParam(':lang_id', $langId, PDO::PARAM_INT);
            $sql->execute();
            $result = $sql->fetch(PDO::FETCH_ASSOC);
        }

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***
 * fctInsertZeroIdEvent: Insert N/A event with ID 0
 */
function fctInsertZeroIdEvent()
{
    $eventId=0;
    $langId=1;
    $title='N/A';
    $description='N/A';
    try {
        $db = new myPDO();
        $db->exec('SET SESSION SQL_MODE ="NO_AUTO_VALUE_ON_ZERO"');

        $sql = $db->prepare("INSERT INTO EVENT (EVEN_ID) VALUES (:even_id)");
        $sql->bindParam(':even_id', $eventId, PDO::PARAM_INT);

        $sql->execute();
        $sql = $db->prepare("INSERT INTO EVEN_LANG_TEXT (EVEN_ID, LANG_ID, TITLE, DESCRIPTION) VALUES (:even_id, :lang_id, :title, :description)");
        $sql->bindParam(':even_id', $eventId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $langId, PDO::PARAM_INT);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
        $sql->bindParam(':description', $description, PDO::PARAM_STR);
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * clearDatabase: clear content of db
 */
function clearEventDatabase()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM EVEN_LANG_TEXT");
        $sql->execute();
        $sql = $db->prepare("DELETE FROM EVENT; ALTER TABLE EVENT AUTO_INCREMENT=1");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * fctInsertDemoData: Test and demo data
 */
function fctInsertEventDemoData()
{
    clearEventDatabase();

    fctEventAdd(1, "Evénement du 20 octobre 2018", "Description événement du 20 octobre 2018", "address", "link", "");
    fctEventTranslateAdd(1, 2, "20th October 2018 event", "20th October 2018 event description");
    fctEventAdd(1, "Evénement du 23 octobre 2018", "Description événement du 23 octobre 2018", "address", "link", "");

//    echo "liste (3)";
//    var_dump($events = fctEventList(0, 1));
//
//    fctEventDelete(2);
//    fctEventEdit(1, 1, "FR description change", "FR titre change", "address1.1", "link1.1", "image1.1");
//    echo "liste (2)";
//    var_dump($events = fctEventList(0, 1));
//    echo "liste (1)";
//    var_dump($events = fctEventList(1));

}

//fctInsertEventDemoData();
//var_dump(fctEventList(1, 0));
