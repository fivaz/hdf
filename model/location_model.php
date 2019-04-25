<?php
/**
 * Created by PhpStorm.
 * User: MAHESALINGAM_MI-ESIG
 * Date: 28.09.2018
 * Time: 09:21
 */

include_once('model.php');

/*** fctLocationAdd: Insert a new Location and return lastInsertId()
 * @param $languageId
 * @param $description
 * @param $title
 * @param $address
 * @return int|string
 */

/***
 * fctInsertZeroIdLocation: Insert N/A event with ID 0 With GVA coordinates
 */
function fctInsertZeroIdLocation()
{
    $locaId = 0;
    $langId = 1;
    $type = 'restaurant';
    $lat = 46.207097;
    $lon = 6.151290;
    $title = 'Genève';
    $title2 = 'Geneva';
    $description = 'N/A';
    try {
        $db = new myPDO();
        $db->exec('SET SESSION SQL_MODE ="NO_AUTO_VALUE_ON_ZERO"');

        $sql = $db->prepare("INSERT INTO LOCATION (LOCA_ID, TYPE, LAT, LON) VALUES (:loca_id, :type, :lat, :lon)");
        $sql->bindParam(':loca_id', $locaId, PDO::PARAM_INT);
        $sql->bindParam(':type', $type, PDO::PARAM_STR);
        $sql->bindParam(':lat', $lat, PDO::PARAM_STR);
        $sql->bindParam(':lon', $lon, PDO::PARAM_STR);
        $sql->execute();

        $sql = $db->prepare("INSERT INTO LOCA_LANG_TEXT (LOCA_ID, LANG_ID, TITLE, DESCRIPTION) VALUES (:loca_id, :lang_id, :title, :description)");
        $sql->bindParam(':loca_id', $locaId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $langId, PDO::PARAM_INT);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
        $sql->bindParam(':description', $description, PDO::PARAM_STR);
        $sql->execute();

        fctLocationTranslateAdd($locaId, $langId, $description, $title2);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}



function fctLocationAdd($languageId, $description, $title, $address)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO LOCATION (ADDRESS,DAY,TYPE) VALUES (:address,:day,:type)");
        $sql->bindParam(':address', $address, PDO::PARAM_STR);
        $sql->bindParam(':day', $day, PDO::PARAM_INT);
        $sql->bindParam(':type', $type, PDO::PARAM_STR);
        $sql->execute();

        $lastLocationId = $db->lastInsertId();

        $sql = $db->prepare("INSERT INTO LOCA_LANG_TEXT (LOCA_ID, LANG_ID, TITLE, DESCRIPTION) VALUES (:loca_id, :lang_id, :title, :description)");
        $sql->bindParam(':loca_id', $lastLocationId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
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
    return $lastLocationId;
}

/*** fctLocationEdit: Edit a Location and return rowCount()
 * @param $locationId
 * @param $languageId
 * @param $description
 * @param $title
 * @param $address
 * @return int
 */
function fctLocationEdit($locationId, $languageId, $description,$day,$type, $title, $address)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("UPDATE LOCATION SET ADDRESS = :address, DAY = :day, TYPE = :type WHERE LOCA_ID = :loca_id");
        $sql->bindParam(':loca_id', $locationId, PDO::PARAM_INT);
        $sql->bindParam(':address', $address, PDO::PARAM_STR);
        $sql->bindParam(':day', $day, PDO::PARAM_INT);
        $sql->bindParam(':type', $type, PDO::PARAM_STR);
        $sql->execute();
        $result = $sql->rowCount();

        $sql = $db->prepare("UPDATE LOCA_LANG_TEXT SET TITLE = :title, DESCRIPTION = :description WHERE LOCA_ID = :loca_id AND LANG_ID = :lang_id");
        $sql->bindParam(':loca_id', $locationId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
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

/*** fctGroupDelete: Delete a Location and return rowCount()
 * @param $locationId
 * @return int
 */
function fctLocationDelete($locationId)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM LOCA_LANG_TEXT WHERE LOCA_ID = :loca_id");
        $sql->bindParam(':loca_id', $locationId, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->rowCount();

        $sql = $db->prepare("DELETE FROM LOCATION WHERE LOCA_ID = :loca_id");
        $sql->bindParam(':loca_id', $locationId, PDO::PARAM_INT);
        $sql->execute();

        $result += $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;
}

/***fctLocationList: Return a List of Location OR a given Location
 * @param int $locationId
 * @param int $languageId
 * @return array
 */


function getLocation($locationId, $languageId)
{
    $location = fctLocationList($locationId, $languageId);
    if(!$location){
        fctLocationTranslateAdd($locationId, $languageId, "","");
        $location = fctLocationList($locationId, $languageId);
    }
    return $location;
}


function fctLocationList($locationId = 0, $languageId = 1)
{
    try {
        $db = new myPDO();

        if ($locationId > 0) {
            $sql = $db->prepare("SELECT * FROM LOCATION e JOIN LOCA_LANG_TEXT l ON l.LOCA_ID = e.LOCA_ID WHERE e.LOCA_ID =:loca_id AND l.LANG_ID = :lang_id  ");
            $sql->bindParam(':loca_id', $locationId, PDO::PARAM_INT);
            $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
            // $locationCherchée[0].['TITLE']
        } else {
            $sql = $db->prepare("SELECT * FROM LOCATION e JOIN LOCA_LANG_TEXT l ON l.LOCA_ID = e.LOCA_ID WHERE l.LANG_ID = :lang_id");
            $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
        }

        $sql->execute();
        $Locations = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $Locations;
}

/*** fctLocationTranslateAdd : translate the location
 * @param $locationId
 * @param $languageId
 * @param $description
 * @param $title
 * @return int
 */

function fctLocationTranslateAdd($locationId, $languageId, $description, $title)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO LOCA_LANG_TEXT (LOCA_ID, LANG_ID, TITLE, DESCRIPTION) VALUES (:loca_id, :lang_id, :title, :description)");
        $sql->bindParam(':loca_id', $locationId, PDO::PARAM_INT);
        $sql->bindParam(':lang_id', $languageId, PDO::PARAM_INT);
        $sql->bindParam(':title', $title, PDO::PARAM_STR);
        $sql->bindParam(':description', $description, PDO::PARAM_STR);
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
function clearLocationDatabase()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("DELETE FROM LOCA_LANG_TEXT");
        $sql->execute();
        $sql = $db->prepare("DELETE FROM LOCATION; ALTER TABLE LOCATION AUTO_INCREMENT=1");
        $sql->execute();
        echo "Clear !";

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
}

/***
 * fctInsertDemoData: Test and demo data
 */
function fctInsertLocationDemoData()
{
//    clearLocationDatabase();

    fctLocationAdd(1, "Près de l'arrêt Lignon-Cité", "Lundi", "Avenue du lignon 54, 1219 le Lignon");
    fctLocationAdd(1, "", "Mardi", "Avenue Cardinal-Mermillod 23, 1227 Carouge");
    fctLocationAdd(1, "Proche du skatepark", "Mercredi", "Rue Dancet 22, 1205 Genève");
//    fctLocationAdd(1, "Description 1", "Title1", "Adresse1"); //1
//    fctLocationTranslateAdd(1, 2, "DescriptionEN", "Title EN");
//    fctLocationAdd(1, "Description 2", "Title2", "Adresse2"); //2
//    fctLocationAdd(1, "Description 3", "Title3", "Adresse3"); //3
//    var_dump(fctLocationList());
//    fctLocationEdit(1, 1, "Description1.1", "Title1.1", "Adresse1.1");
//    fctLocationDelete(2);
//    var_dump(fctLocationList());
//    echo "1:";
//    var_dump(fctLocationList(3));

}
//fctInsertLocationDemoData();