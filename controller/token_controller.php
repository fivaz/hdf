<?php
/**
 * Token controller for feedbackEmailConfirm, userEmailConfirm, userEmailChange,
 *  contactEmailChange and userPasswordReset --> should be included after the action itself.
 * User: Frank Théodoloz
 * Date: 21/10/2018
 * Time: 23:50
 */

include_once(dirname(__DIR__) . "/global.php");
include_once('../model/token_model.php');
include_once('../model/feedback_model.php');

//when $_GET is defined using email verification token link
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $target = "../view/main.php";

    if (!($tokenDetails = fctTokenDetail($token))) {
        header("Location: ../view/main.php?error-msg=" . $lang['token_not_found']);

    } else {

        //check token datetime
        $now = date('Y-m-d H:i:s');
        $delay = strtotime("+24 Hour");

        if (date($tokenDetails['DATETIME'], $delay) > $now) {
            fctTokenDelete($token);
            header("Location: ../view/main.php?error-msg=" . $lang['expired_token']);

        } else {
            switch ($tokenDetails['TYPE']) {

                //Feedback email confirmation: Update FEEDBACK(S), confirmed = 1
                case 'feedbackEmailConfirm':
                    $email = $tokenDetails['VALUE']; //email
                    $result = fctFeedbackEmailConfirm($email);

                    break;

                //User email confirmation: Update USER, Enabled = 1
                case 'userEmailConfirm':
                    $id = $tokenDetails['ID'];
                    $result = fctUserEmailConfirm($id);

                    break;

                //User email change confirmation: Update USER, apply new email
                case 'userEmailChange':
                    $id = $tokenDetails['ID'];
                    $value = $tokenDetails['VALUE'];
                    $result = fctUserEmailChange($id, $value); //USER_ID

                    break;

                //Contact email change confirmation: Update PARAMETER --> apply new contact email
                case 'contactEmailChange':
                    $email = $tokenDetails['VALUE'];
                    $result = fctContactEmailConfirm($email);

                    break;

                //User password reset:
                case 'userPasswordReset':
                    header('location: ../view/userPasswordChangeReset.php?token=' . $token);
                    break;
            }
        }
        if ($result == 1) { //Everything's allright
            fctTokenDelete($token);
            $message = "?success-msg=Vérification de l'adresse email réussie.";
        } else {
//            fctTokenDelete($token); //TODO NE DEVRAIT PAS ETRE EFFACE !!!!!!
            $message = "?error-msg=La vérification de l'adresse a échoué.";

        }
        //header("Location: " . $target . $message);
    }

//when $_POST is defined for verification request
} else if (isset($_POST['action'])) {

    $action = $_POST['action'];
    $id = NULL;

    include_once('email_controller.php');

    // $tokenLink = 'http://localhost/HDF/view/token.php?token=';
    //$tokenLink = 'http://esig-sandbox.ch/team2018_4/view/token.php?token=';
    $tokenLink = "http://$_SERVER[HTTP_HOST]/".SITEPATH."/view/token.php?token=";

    switch ($action) {

        //Feedback email confirm
        case 'feedbackSend':
            $email = $_POST['feedbackEmail'];

            $token = fctTokenAdd("feedbackEmailConfirm", $email);
            $tokenLink .= $token;

            $subject = "THDF : Confirmation de votre feedback";
            $body = "Veuillez cliquer sur ce lien pour confirmer votre adresse email <br/>
             et valider votre avis laissé sur le site The Hot Dog Faktory : " . $tokenLink;

            break;

        //User email confirmation
        case 'register':

            $subject = "THDF : Confirmation de votre email";
            $body = "Veuillez cliquer sur ce lien pour valider activer votre compte <br/>
             sur le site The Hot Dog Faktory  : " . $tokenLink;

            break;

        //User email change confirmation
        case 'userEmailChange':

            $subject = "THDF : Confirmation changement d'email";
            $body = "Veuillez cliquer sur ce lien pour confirmer le changement de votre adresse email <br/>
             sur le site The Hot Dog Faktory  : " . $tokenLink;

            break;

        //Contact email change confirmation
        case 'contactEmailChange':
            $target = "../view/parameter.php";
            $message = "?success-msg=" . $lang['contact_email_message'];

            $email = $_POST['CONTACT_EMAIL'];

            $token = fctTokenAdd("contactEmailChange", $email);
            $tokenLink .= $token;

            $subject = "THDF : Confirmation changement d'email de contact";
            $body = "Veuillez cliquer sur ce lien pour confirmer le changement de l'adresse email de contact du site The Hot Dog Faktory  : " . $tokenLink;

            break;

        //User password reset
        case 'passwordReset':
            $target = "../view/main.php";
            $message = "?success-msg=" . $lang['password_reset_sent'];

            $email = $emailFound['EMAIL']; //$emailFound is defined in user_controller

            $token = fctTokenAdd("userPasswordReset", $email);
            $tokenLink .= $token;

            $subject = "THDF : Changement de votre mot de passe";
            $body = "Veuillez cliquer sur ce lien pour effectuer le changement du mot de passe de votre compte <br/>
             sur le site The Hot Dog Faktory  : " . $tokenLink;

            break;

        default:
            echo 'Error: Token action';
            break;
    }

    //envoi du message
    if ($subject) {
        fctSendMail($email, $subject, $body);
        header('Location: ' . $target . $message);
    }

} else {
    echo "Error: Token POST/GET missing";
}
