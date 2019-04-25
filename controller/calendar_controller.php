<?php
/**
 * Controller for the calendar view
 * User: THEODOLOZ_FRANK-ESIG
 * Date: 05.10.2018
 * Time: 11:11
 */

include_once('../model/calendar_model.php');

if (!isset($_POST['action'])) {
    echo('clickEvent error: undefined action');
    //TODO ERROR HANDLING

} else {
    $action = $_POST['action'];

    if ($action == 'detail') {
        $eventType = $_POST['eventType'];
        $languageId = $_POST['languageId'];
        $itemId = $_POST['itemId'];

        if($languageId == 1){
            setlocale(LC_TIME ,'French_Switzerland.UTF8','fr_CH.UTF8');
        }else{
            setlocale(LC_TIME ,'English_United_Kingdom.1252', 'en_GB.1252');
        }

        if ($eventType = 'EVENT') {

            $detail = fctCalendarEventDetail($languageId, $itemId);

            $e = array();
            $e['TITLE'] = $detail['TITLE'];
            $e['DESCRIPTION'] = $detail['DESCRIPTION'];
            $e['ADDRESS'] = $detail['ADDRESS'];

//            $e['DATETIME_START'] = date('l j F Y G:i',strtotime($detail['DATETIME_START']));
            $e['DATETIME_START'] = strftime('%A %e %B %Y %H:%M',strtotime($detail['DATETIME_START']));
//            $e['DATETIME_END'] = date('l j F Y G:i',strtotime($detail['DATETIME_END']));
            $e['DATETIME_END'] = strftime('%A %e %B %Y %H:%M',strtotime($detail['DATETIME_END']));

            $e['LINK'] = $detail['LINK'];
            $e['IMAGE'] = base64_encode($detail['IMAGE']);
            $e['EVEN_ID'] = $detail['EVEN_ID'];
            $e['CALE_ID'] = $detail['CALE_ID'];

        } else if ($eventType = 'LOCATION') {

            $detail = fctCalendarLocationDetail($languageId, $itemId);

            $e = array();
            $e['TITLE'] = $detail['TITLE'];
            $e['DESCRIPTION'] = $detail['DESCRIPTION'];
            $e['ADDRESS'] = $detail['ADDRESS'];
            $e['LOCA_ID'] = $detail['LOCA_ID'];
            $e['CALE_ID'] = $detail['CALE_ID'];

        } else {
            echo "Error : event/location ";
            //TODO ERROR HANDLING
        }
        echo json_encode($e);
        exit();


    } else if ($action == 'listEvents') {
        $languageId = $_POST['languageId'];
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];

        $result = fctCalendarEventsList($languageId, $date_from, $date_to);
        $eventList = array();

        foreach ($result as $row) {

            $e = array();
            $e['id'] = $row['CALE_ID'];
            $e['type'] = $row['PARENT_TYPE'];
            $e['title'] = $row['TITLE'];
            $e['start'] = $row['DATETIME_START'];
            $e['end'] = $row['DATETIME_END'];
            $e['itemId'] = $row['EVEN_ID'];
            $e['link'] = $row['LINK'];
            $e['descr'] = $row['DESCRIPTION'];

            // Merge the event array into the return array
            array_push($eventList, $e);
        }

        // Output json for our calendar
        echo json_encode($eventList);
        exit();

    } else if ($action == 'listLocations') {
        $languageId = $_POST['languageId'];
        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];

        $result = fctCalendarLocationsList($languageId, $date_from, $date_to);
        $locationList = array();

        foreach ($result as $row) {

            $e = array();
            $e['id'] = $row['CALE_ID'];
            $e['type'] = $row['PARENT_TYPE'];
            $e['title'] = $row['TITLE'];
            $e['start'] = $row['DATETIME_START'];
            $e['end'] = $row['DATETIME_END'];
            $e['itemId'] = $row['LOCA_ID'];
            $e['link'] = $row['LINK'];
            $e['descr'] = $row['DESCRIPTION'];

            // Merge the event array into the return array
            array_push($eocationList, $e);
        }

        // Output json for our calendar
        echo json_encode($locationList);
        exit();

    } else {
        echo "Calendar error: unknown action ";
        //TODO ERROR HANDLING
    }
}
