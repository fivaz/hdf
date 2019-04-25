<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 01/10/2018
 * Time: 23:05
 */

include_once('../model/event_model.php');
include_once('../model/calendar_model.php');

//$target = "../view/calendar.php";

if (!isset($_POST['action'])) {
    echo('Form error: undefined action');
    //TODO ERROR HANDLING
    //header('Location: ../view/eventAdd.php');

} else {
    $action = $_POST['action'];

    if ($action == 'proposition') {

        if (!isset($_POST['eventName']) || !isset($_POST['eventDate']) || !isset($_POST['eventContactEmail']) || !isset($_POST['eventContactMessage'])) {
            echo "Form error: Event details missing field";
            //TODO ERROR HANDLING
            //header('location: ../view/eventAdd.php');

        } else {
            $eventName = $_POST['eventName'];
            $eventStartDate = $_POST['eventDate'];
            $eventEndDate = $_POST['eventDate'];
            $eventContactEmail = $_POST['eventContactEmail'];
            $eventContactMessage = $_POST['eventContactMessage'];
        }

    } else if ($action == 'eventAdd') {

        if (!isset($_POST['eventTitle']) || !isset($_POST['eventStartDate']) || !isset($_POST['eventEndDate']) ||
            !isset($_POST['eventDescription']) || !isset($_POST['eventAddress'])) {
            echo "Form error: Event details missing field1";
            //TODO ERROR HANDLING
            //header('location: ../view/eventAdd.php');

        } else {
            !isset($_POST['languageId']) ? $languageId = "" : $languageId = $_POST['languageId'];
            !isset($_POST['eventLink']) ? $eventLink = "" : $eventLink = $_POST['eventLink'];
            !isset($_FILES['eventImage']['tmp_name']) ? $eventImage = "" : $eventImage = file_get_contents($_FILES['eventImage']['tmp_name']);


            $eventAddress = $_POST['eventAddress'];
            $eventTitle = $_POST['eventTitle'];
            $eventDescription = $_POST['eventDescription'];

            //DB 2018-01-01 17:00 -> locale fr : 01/01/2018 17:00
            $eventStartDate = $_POST['eventStartDate'];
            $dateStart = date_create_from_format('d/m/Y H:i', $eventStartDate);

            $eventEndDate = $_POST['eventEndDate'];
            $dateEnd = date_create_from_format('d/m/Y H:i', $eventEndDate);

            $eventId = fctEventAdd($languageId, $eventTitle, $eventDescription, $eventAddress, $eventLink, $eventImage);
            fctCalendarAdd(0, $eventId, "EVENT", date_format($dateStart, 'Y-m-d H:i'), date_format($dateEnd, 'Y-m-d H:i'));

            header("location: ../view/eventEdit?id=" . $eventId."&success-msg=Evénement ajouté");


        }

    } else if ($action == 'eventEdit') {
        if (!isset($_POST['eventId']) || !isset($_POST['languageId']) || !isset($_POST['eventTitle']) ||
            !isset($_POST['eventStartDate']) || !isset($_POST['eventEndDate']) || !isset($_POST['eventDescription']) || !isset($_POST['eventAddress'])) {
            echo "Form error: Event details missing field";
            //TODO ERROR HANDLING
            //header('location: ../view/eventAdd.php');

        } else {
            !isset($_POST['eventLink']) ? $eventLink = "" : $eventLink = $_POST['eventLink'];
            $eventId = $_POST['eventId'];
            $calendarId = $_POST['calendarId'];
            $languageId = $_POST['languageId'];
            $eventAddress = $_POST['eventAddress'];
            $eventTitle = $_POST['eventTitle'];
            $eventDescription = $_POST['eventDescription'];

            //DB 2018-01-01 17:00 -> locale fr : 01/01/2018 17:00
            $eventStartDate = $_POST['eventStartDate'];
            $dateStart = date_create_from_format('d/m/Y H:i', $eventStartDate);

            $eventEndDate = $_POST['eventEndDate'];
            $dateEnd = date_create_from_format('d/m/Y H:i', $eventEndDate);

            fctEventEdit($eventId, $languageId, $eventTitle, $eventDescription, $eventAddress, $eventLink);
            fctCalendarEdit($calendarId, 0, $eventId, "EVENT", date_format($dateStart, 'Y-m-d H:i'), date_format($dateEnd, 'Y-m-d H:i'));

            header("location: ../view/eventEdit?id=" . $eventId."&success-msg=Evénement modifié");

        }

    } else if ($action == 'eventEditImage') {

        if (!isset($_POST['eventId']) || !isset($_FILES['eventImage']['tmp_name'])) {
            echo "Form error: Edit image missing field";
            //TODO ERROR HANDLING
            //header('location: ../view/eventAdd.php');

        } else {
            $eventId = $_POST['eventId'];
            $eventImage = file_get_contents($_FILES['eventImage']['tmp_name']);

            fctEventEditImage($eventId, $eventImage);

            header("location: ../view/eventEdit?id=" . $eventId."&success-msg=Image modifiée");
        }

    } else if ($action == 'eventDelete') {

        if (!isset($_POST['eventId'])) {
            echo "Form error: Edit image missing field";
            //TODO ERROR HANDLING
            //header('location: ../view/eventAdd.php');

        } else {
            $eventId = $_POST['eventId'];

            fctEventDelete($eventId);

            header("location: ../view/calendar.php?success-msg=Evénement supprimé");
        }

    } else {
//        header('Location: ../view/calendar.php');
    }
//    header("location:" . $target);
}