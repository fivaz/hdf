<?php
//TESTS
include_once('../../model/model.php');

// database settings
$db_username = 'root';
$db_password = '';
$db_name = 'test';
$db_host = 'localhost';

//mysqli
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

if (mysqli_connect_errno()) {

    header('HTTP/1.1 500 Error: Could not connect to db!');
    exit();
}


function fctLocationAdd($languageId, $description, $title, $address, $lat, $lon)
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("INSERT INTO LOCATION (ADDRESS, LAT, LON) VALUES (:address, :lat, :lon)");
        $sql->bindParam(':address', $address, PDO::PARAM_STR);
        $sql->bindParam(':lat', $lat, PDO::PARAM_STR);
        $sql->bindParam(':lon', $lon, PDO::PARAM_STR);
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

function fctLocationDelete($lat, $lon)
{

    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT * FROM LOCATION WHERE LAT = :lat AND LON = :lon");
        $sql->bindParam(':lat', $lat, PDO::PARAM_LOB);
        $sql->bindParam(':lon', $lon, PDO::PARAM_LOB);
        $sql->execute();

        $location = $sql->fetch(PDO::FETCH_ASSOC); //retourne la colonne seulement

        $locaId = $location['LOCA_ID'];

        $sql = $db->prepare("DELETE FROM LOCA_LANG_TEXT WHERE LOCA_ID = :loca_id");
        $sql->bindParam(':loca_id', $locaId, PDO::PARAM_INT);
        $sql->execute();

        $result = $sql->rowCount();

        $sql = $db->prepare("DELETE FROM LOCATION WHERE LOCA_ID = :loca_id");
        $sql->bindParam(':loca_id', $locaId, PDO::PARAM_INT);
        $sql->execute();

        $result += $sql->rowCount();

    } catch (PDOException $e) {

        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $result;

}

function fctLocationList()
{
    try {
        $db = new myPDO();

        $sql = $db->prepare("SELECT * FROM LOCATION e JOIN LOCA_LANG_TEXT l ON l.LOCA_ID = e.LOCA_ID");
        $sql->execute();
        $Locations = $sql->fetchall(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("SQL Error (" . __FUNCTION__ . ") " . $e->getMessage());
    }
    $db = NULL; // Close connection
    return $Locations;
}

//end test queries

//if (mysqli_connect_errno()) {
//    header('HTTP/1.1 500 Error: Could not connect to db!');
//    exit();
//}

################ Save & delete LOCATION #################
if ($_POST) //run only if there's a post data
{
    //make sure request is comming from Ajax
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
    if (!$xhr) {
        header('HTTP/1.1 500 Error: Request must come from Ajax!');
        exit();
    }

    // get marker position and split it for database
    $mLatLang = explode(',', $_POST["latlang"]);
    $mLat = filter_var($mLatLang[0], FILTER_VALIDATE_FLOAT);
    $mLng = filter_var($mLatLang[1], FILTER_VALIDATE_FLOAT);

    //Delete Marker
    if (isset($_POST["del"]) && $_POST["del"] == true) //$mLat $mLng
    {
        $results = fctLocationDelete($mLat, $mLng);

        if (!$results) {
            header('HTTP/1.1 500 Error: Could not delete Markers!' . $mLat . '-' . $mLng);
            exit();
        }
        exit("Done!");
    }

    //Insert Markers
    $mName = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $mAddress = filter_var($_POST["address"], FILTER_SANITIZE_STRING);
    $mType = filter_var($_POST["type"], FILTER_SANITIZE_STRING);
//    function fctLocationAdd($languageId, $description, $title, $address, $lat, $lon)
    $results = fctLocationAdd(1, "", $mName, $mAddress, $mLat, $mLng);

    if (!$results) {
        header('HTTP/1.1 500 Error: Could not create marker!');
        exit();
    }

    $output = '<h1 class="marker-heading">' . $mName . '</h1><p>' . $mAddress . '</p>';
    exit($output);
}

################ Continue generating Map XML #################

//Create a new DOMDocument object
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers"); //Create new element node
$parnode = $dom->appendChild($node); //make the node show up

// Select all the rows in the markers table

$results = fctLocationList(); //PDO


if (!$results) {
    header('HTTP/1.1 500 Error: Could not get markers!');
    exit();
}

//set document header to text/xml
header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
foreach ($results as $result) {
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name", $result['TITLE']);
    $newnode->setAttribute("address", $result['ADDRESS']);
    $newnode->setAttribute("lat", $result['LAT']);
    $newnode->setAttribute("lng", $result['LON']);
    $newnode->setAttribute("type", "RESTAURANT");
}

echo $dom->saveXML();

