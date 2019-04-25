<?php
/**
 * Created by PhpStorm.
 * User: MAHESALINGAM_MI-ESIG
 * Date: 15.10.2018
 * Time: 10:31
 */

include_once ("../../model/model.php");

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
    echo "résultat: ".$result;
    return $result;

}
fctLocationDelete(46.201408 , 6.143399);
//46.201408 , 6.143399 //id34
//46.201508	6.14525
