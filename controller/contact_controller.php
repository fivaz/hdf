<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 01/10/2018
 * Time: 20:51
 */

include_once('email_controller.php');
include_once('../model/parameter_model.php');

if (!isset($_POST['action'])) {
    echo('Form error: undefined action');
    //TODO ERROR HANDLING
//    header('Location: ../view/contact.php');

} else {

    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }
    if (!$captcha) {
        echo '<h2>Please check the captcha form.</h2>';
        exit;
    }

    $secretKey = "6LduMXMUAAAAAJG0ksC-cU7utzC0eEG6g1CbhMN1";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        //Captcha error
        header('Location: ../view/contact.php');

    } else {

        $action = $_POST['action'];

        if ($action == 'contact') {

            if (!isset($_POST['contactName']) || !isset($_POST['contactEmail']) || !isset($_POST['contactSubject']) || !isset($_POST['contactMessage'])) {
                echo "Form error: Contact missing field";
                //TODO ERROR HANDLING
//                header('location: ../view/contact.php');

            } else {
                $contactName = $_POST['contactName'];
                $contactEmail = $_POST['contactEmail'];
                $contactSubject = $_POST['contactSubject'];
                $contactMessage = $_POST['contactMessage'];

                $subject = "THDF : Contact de " . $_POST['contactName'];
                $body = "Vous avez reçu un message de la part de " . $contactName . " (" . $contactEmail . ") : <br/>";
                $body .= $contactMessage;
                $to = fctParameterGet('CONTACT_EMAIL');

                fctSendMail($to, $subject, $body);
                header("Location: ../view/main.php?success-msg=".$lang['contact_sent_confirm']);

            }

        } else if ($action == 'proposition') {

            if (!isset($_POST['eventName']) || !isset($_POST['eventDate']) || !isset($_POST['eventContactMessage']) ||
                !isset($_POST['eventContactEmail']) || !isset($_POST['eventContactPhone']) || !isset($_POST['eventContactPhone'])) {
                echo "Form error: Proposition missing field";
                //TODO ERROR HANDLING
//                header('location: ../view/event.php');

            } else {
                $eventName = $_POST['eventName'];
                $eventDate = $_POST['eventDate'];
                $eventContactMessage = $_POST['eventContactMessage'];
                $eventContactEmail = $_POST['eventContactEmail'];
                $eventContactPhone = $_POST['eventContactPhone'];

                $subject = "THDF : Proposition d'événement" . $eventName;
                $body="<meta http-equiv=\"Content-Type\"  content=\"text/html charset=UTF-8\" />";
                $body .= "Vous avez reçu un message pour un événement le " . $eventDate . ". <br/>";
                $body .= "Coordonnées :<br/>";
                $body .= "Email " . $eventContactEmail."<br/>";
                $body .= "Téléphone " . $eventContactPhone."<br/>";
                $to = fctParameterGet('CONTACT_EMAIL');

                fctSendMail($to, $subject, $body);
                header("Location: ../view/event.php?success-msg=".$lang['contact_sent_confirm']);
            }

        } else {
            echo "Form error: Event details missing field";
            //TODO ERROR HANDLING
        }
    }
}


