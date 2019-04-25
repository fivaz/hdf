<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 01/10/2018
 * Time: 23:05
 */

include_once('../model/location_model.php');

$target = "location.php";

if (!isset($_POST['action'])) {
    header('Location: ../view/locationAdd.php');
} else {
    $action = $_POST['action'];

    if ($action == 'locationAdd') {

        if (!isset($_POST['locationTitle']) && !isset($_POST['locationAddress']) && !isset($_POST['locationDescription'])) {
            header('location: ../view/locationAdd.php');

        } else {
            $locationTitle = $_POST['locationTitle'];
            $locationAddress = $_POST['locationAddress'];
            $locationDescription = $_POST['locationDescription'];

            $lastid = fctLocationAdd(1, $locationDescription, $locationTitle, $locationAddress);
            var_dump(fctLocationList($lastid));
        }

    } else if ($action == 'locationEdit') { // A MODIFIER !
        $target = "location.php";

        if (!isset($_POST['locationTitle']) && !isset($_POST['locationId']) && !isset($_POST['locationAddress']) && !isset($_POST['locationDescription'])) {
            header('location: ../view/location.php');

        } else {
            $locationDay = $_POST['locationDay'];
            $locationType = $_POST['locationType'];
            $locationId = $_POST['locationId'];
            $languageId = $_POST['languageId'];
            $locationTitle = $_POST['locationTitle'];
            $locationAddress = $_POST['locationAddress'];
            $locationDescription = $_POST['locationDescription'];

//            $lastid = fctLocationAdd(1, $locationDescription, $locationTitle, $locationAddress); //fctLocationEdit
            fctLocationEdit($locationId, $languageId, $locationDescription,$locationDay,$locationType, $locationTitle, $locationAddress);
//            echo $locationDay;
        }
    } else {
//        header('Location: ../view/locationAdd.php');
        echo('erreur action'); //debug
    }

//    header('Location: ../view/' . $target.'?id='.$lastid); //exemple avec id
    header('Location: ../view/' . $target);
}
