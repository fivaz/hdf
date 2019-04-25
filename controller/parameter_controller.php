<?php
/**
 * Parameter controller
 * User: THEODOLOZ_FRANK-ESIG
 * Date: 04.10.2018
 * Time: 10:10
 */

include_once(dirname(__DIR__) . "/global.php");
include_once('../model/parameter_model.php');
include_once('../model/token_model.php');

if (!isset($_POST['action'])) {
    echo('Form error: undefined action');
    //TODO ERROR HANDLING
    //header('Location: ../view/parameter.php');

} else {
    $action = $_POST['action'];

    if ($action == 'updateDetails') {

        if (!isset($_POST['COMPANY_NAME']) || !isset($_POST['CONTACT_PHONE']) || !isset($_POST['ADDRESS1']) || !isset($_POST['ADDRESS2'])) {
            echo "Form error: Parameter details missing field";
            //TODO ERROR HANDLING

        } else {

            $company_name = $_POST['COMPANY_NAME'];
            $phone = $_POST['CONTACT_PHONE'];
            $address1 = $_POST['ADDRESS1'];
            $address2 = $_POST['ADDRESS2'];
            !isset($_POST['LINK_TWITTER']) ? $twitter = "" : $twitter = $_POST['LINK_TWITTER'];;
            !isset($_POST['LINK_TRIPADVISOR']) ? $tripadvisor = "" : $tripadvisor = $_POST['LINK_TRIPADVISOR'];
            !isset($_POST['LINK_INSTAGRAM']) ? $instagram = "" : $instagram = $_POST['LINK_INSTAGRAM'];
            !isset($_POST['LINK_FACEBOOK']) ? $facebook = "" : $facebook = $_POST['LINK_FACEBOOK'];

            fctParameterEdit("COMPANY_NAME", $company_name);
            fctParameterEdit("CONTACT_PHONE", $phone);
            fctParameterEdit("ADDRESS1", $address1);
            fctParameterEdit("ADDRESS2", $address2);
            fctParameterEdit("LINK_TWITTER", $twitter);
            fctParameterEdit("LINK_TRIPADVISOR", $tripadvisor);
            fctParameterEdit("LINK_INSTAGRAM", $instagram);
            fctParameterEdit("LINK_FACEBOOK", $facebook);

            header("Location: ../view/parameter.php?success-msg=".$lang['parameters_updated']);

        }
    } else if ($action == 'updateLogo') {

        if (!isset($_FILES['logo']['tmp_name'])) {
            echo "Form error: Parameter Logo missing field";
            //TODO ERROR HANDLING

        } else {
            $image = file_get_contents($_FILES['logo']['tmp_name']);
            fctParameterLogoUpdate($image);
            header("Location: ../view/parameter.php?success-msg=".$lang['logo_updated']);

        }

    } else if ($action == 'contactEmailChange') {

        if (!isset($_POST['CONTACT_EMAIL'])) {
            echo "Form error: contactEmailChange missing field";
            //TODO ERROR HANDLING

        } else {
            //changes will be applied later when email is confirmed
            include_once('token_controller.php');
        }

    } else {
        //header('Location: ../view/eventAdd.php');
        echo "Error: Parameter action missing";
    }

//    header('Location: ../view/parameter.php');


}