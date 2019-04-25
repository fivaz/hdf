<?php
/**
 * Created by PhpStorm.
 * User: Frank Théodoloz
 * Date: 27.09.2018
 * Time: 15:55
 */

include_once('model.php');

/***fctCalendarAdd: Add a calendar and return lastInsertId()
 * @param int $locationId
 * @param int $eventId default=null (None)
 * @param $type
 * @param $datetimeStart
 * @param $datetimeEnd
 * @return int|string
 */
function fctCalendarAdd($locationId, $eventId, $type, $datetimeStart, $datetimeEnd)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO CALENDAR (LOCA_ID, EVEN_ID, PARENT_TYPE, DATETIME_START, DATETIME_END) VALUES (:locaId, :evenId, :type, :dateStart, :dateEnd)");

        $sql->bindParam(':locaId', $locationId, PDO::PARAM_INT);
        $sql->bindParam(':evenId', $eventId, PDO::PARAM_INT);
        $sql->bindParam(':type', $type, PDO::PARAM_STR);
        $sql->bindParam(':dateStart', $datetimeStart, PDO::PARAM_STR);
        $sql->bindParam(':dateEnd', $datetimeEnd, PDO::PARAM_STR);
        $sql->execute();

        $lastCalendarId = $db->lastInsertId();

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
    return $lastCalendarId;
}

/***fctCalendarEventEdit: Edit a Calendar and return rowCount()
 * @param $calendarId
 * @param $locationId
 * @param $eventId
 * @param $type
 * @param $datetimeStart
 * @param $datetimeEnd
 * @return int
 */
function fctCalendarEdit($calendarId, $locationId, $eventId, $type, $datetimeStart, $datetimeEnd)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE CALENDAR SET LOCA_ID = :locaId,  EVEN_ID = :evenId , PARENT_TYPE = :type, DATETIME_START = :dateStart, DATETIME_END = :dateEnd  WHERE CALE_ID = :caleId");
        $sql->bindParam(':caleId', $calendarId, PDO::PARAM_INT);
        $sql->bindParam(':locaId', $locationId, PDO::PARAM_INT);
        $sql->bindParam(':evenId', $eventId, PDO::PARAM_INT);
        $sql->bindParam(':type', $type, PDO::PARAM_STR);
        $sql->bindParam(':dateStart', $datetimeStart, PDO::PARAM_STR);
        $sql->bindParam(':dateEnd', $datetimeEnd, PDO::PARAM_STR);
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

/***fctCalendarEventEdit: Edit a Calendar Event and return rowCount()
 * @param $eventId
 * @param $datetimeStart
 * @param $datetimeEnd
 * @return int
 */
function fctCalendarEventEdit($eventId, $datetimeStart, $datetimeEnd)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE CALENDAR SET DATETIME_START = :dateStart, DATETIME_END = :dateEnd  WHERE EVEN_ID = :evenId");
        $sql->bindParam(':evenId', $eventId, PDO::PARAM_INT);
        $sql->bindParam(':dateStart', $datetimeStart, PDO::PARAM_STR);
        $sql->bindParam(':dateEnd', $datetimeEnd, PDO::PARAM_STR);
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

/***fctCalendarLocationEdit: Edit a Calendar Location and return rowCount()
 * @param int $locationId
 * @param int $datetimeStart
 * @param int $datetimeEnd
 * @return int
 */
function fctCalendarLocationEdit($locationId, $datetimeStart, $datetimeEnd)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE CALENDAR SET DATETIME_START = :dateStart, DATETIME_END = :dateEnd  WHERE LOCA_ID = :locaId");
        $sql->bindParam(':locaId', $locationId, PDO::PARAM_INT);
        $sql->bindParam(':dateStart', $datetimeStart, PDO::PARAM_STR);
        $sql->bindParam(':dateEnd', $datetimeEnd, PDO::PARAM_STR);
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

/*** fctCalendarDelete: Delete a Calendar and return rowCount()
 * @param int $calendarId
 * @return int
 */
function fctCalendarDelete($calendarId)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM CALENDAR WHERE CALE_ID = :calendar_id");
        $sql->bindParam(':calendar_id', $calendarId, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/*** fctCalendarEventDelete: Delete a Calendar Event and return rowCount()
 * @param int $eventId
 * @return int
 */
function fctCalendarEventDelete($eventId)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM CALENDAR WHERE EVEN_ID = :event_id");
        $sql->bindParam(':event_id', $eventId, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/*** fctCalendarLocationDelete: Delete Calendar Locations and return rowCount()
 * @param int $locaId
 * @return int
 */
function fctCalendarLocationDelete($locaId)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM CALENDAR WHERE LOCA_ID = :location_id");
        $sql->bindParam(':location_id', $locaId, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/*** fctCalendarLocationDateDelete: Delete Calendar Locations btw dates and return rowCount()
 * @param int $locaId
 * @param datetime $date_from
 * @param datetime $date_to
 * @return int
 */
function fctCalendarLocationDeleteByDate($locaId, $date_from, $date_to)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM CALENDAR WHERE LOCA_ID = :location_id AND DATETIME_START >= :date_from AND DATETIME_END <= :date_to");
        $sql->bindParam(':location_id', $locaId, PDO::PARAM_INT);
        $sql->bindParam(':date_from', $date_from, PDO::PARAM_STR);
        $sql->bindParam(':date_to', $date_to, PDO::PARAM_STR);
        $sql->execute();

        $result = $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctCalendarList: Return a details of an Event (clickEvent)
 * @param int $languageId
 * @param int $eventId
 * @return array
 */
function fctCalendarEventDetail($languageId, $eventId)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT *
                                        FROM CALENDAR c
                                          JOIN EVENT e on e.EVEN_ID = c.EVEN_ID
                                          LEFT JOIN EVEN_LANG_TEXT el on el.EVEN_ID = e.EVEN_ID AND el.LANG_ID = :langId
                                          WHERE e.EVEN_ID = :even_Id");
        $sql->bindParam(':langId', $languageId, PDO::PARAM_INT);
        $sql->bindParam(':even_Id', $eventId, PDO::PARAM_INT);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);


    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctCalendarList: Return a details of a Location (clickEvent)
 * @param int $languageId
 * @param int $locationId
 * @return array
 */
function fctCalendarLocationDetail($languageId, $locationId)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT *
                                        FROM CALENDAR c
                                          JOIN EVENT e on e.EVEN_ID = c.EVEN_ID
                                          JOIN EVEN_LANG_TEXT el on el.EVEN_ID = e.EVEN_ID AND el.LANG_ID = :langId
                                          WHERE e.EVEN_ID = :even_Id");
        $sql->bindParam(':langId', $languageId, PDO::PARAM_INT);
        $sql->bindParam(':loca_Id', $locationId, PDO::PARAM_INT);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);


    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctCalendarEventsList: Return a List of Event for fullcalendar(eventSource)
 * @param int $languageId
 * @param datetime $date_from
 * @param datetime $date_to
 * @return array
 */
function fctCalendarEventsList($languageId, $date_from, $date_to)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT CALE_ID,c.LOCA_ID,c.EVEN_ID,PARENT_TYPE,DATETIME_START,DATETIME_END,TITLE,LINK,DESCRIPTION
                                        FROM CALENDAR c
                                          JOIN EVENT e on e.EVEN_ID = c.EVEN_ID
                                          JOIN EVEN_LANG_TEXT t on t.EVEN_ID = e.EVEN_ID AND t.LANG_ID = :langId
                                          WHERE c.DATETIME_START >= :date_from AND c.DATETIME_START <= :date_to ");
        $sql->bindParam(':langId', $languageId, PDO::PARAM_INT);
        $sql->bindParam(':date_from', $date_from, PDO::PARAM_STR);
        $sql->bindParam(':date_to', $date_to, PDO::PARAM_STR);
        $sql->execute();
        $result = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctCalendarLocationsList: Return a List for fullcalendar (eventSource)
 * @param int $languageId
 * @param datetime $date_from
 * @param datetime $date_to
 * @return array
 */
function fctCalendarLocationsList($languageId, $date_from, $date_to)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT CALE_ID,c.LOCA_ID,c.EVEN_ID,PARENT_TYPE,DATETIME_START,DATETIME_END,TITLE,DESCRIPTION
                                            FROM CALENDAR c
                                              JOIN LOCATION l on l.LOCA_ID = c.LOCA_ID
                                              JOIN LOCA_LANG_TEXT t on t.LOCA_ID = l.LOCA_ID AND t.LANG_ID = :langId
                                              WHERE c.DATETIME_START >= :date_from AND c.DATETIME_END <= :date_to ");
        $sql->bindParam(':langId', $languageId, PDO::PARAM_INT);
        $sql->bindParam(':date_from', $date_from, PDO::PARAM_STR);
        $sql->bindParam(':date_to', $date_to, PDO::PARAM_STR);
        $sql->execute();
        $result = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***
 * clearDatabase: Clear content of db
 */
function clearCalendarDatabase()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM CALENDAR; ALTER TABLE CALENDAR AUTO_INCREMENT=1");
        $sql->execute();

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * fctInsertDemoData: Test and demo data
 */
function fctInsertCalendarDemoData()
{
    clearCalendarDatabase();

    fctCalendarAdd(1, 1, "EVENT", "2018-12-01 11:00:00", "2018-12-01 14:00:00");
    fctCalendarAdd(1, 0, "EVENT", "2018-12-02 11:00:00", "2018-12-02 14:00:00");
    var_dump(fctCalendarList());
    fctCalendarDelete(2);
    fctCalendarEdit(1, 1, null, "EVENT", "2018-12-01 11:00:00", "2018-12-01 14:00:00");
    var_dump(fctCalendarList());

}

//fctInsertCalendarDemoData();