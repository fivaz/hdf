<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 01/10/2018
 * Time: 23:05
 */

include_once('../model/feedback_model.php');
include_once('../model/user_model.php');
$published = 0;


if (!isset($_POST['action'])) {
    header('Location: ../view/feedback_form.php');
} else {
    $action = $_POST['action'];

    if ($action == 'feedbackSend') {

        if (!isset($_POST['feedbackEmail']) && !isset($_POST['feedbackMessage']) && !isset($_POST['feedbackNumber']) && !isset($_POST['feedbackTitle']) && !isset($_POST['userId'])) {
            header('location: ../view/feedback_form.php');

        } else {
            $userId = $_POST['userId'];

            if ($userId > 0) { //user connu donc pas de nom envoyé
                $userDetail = fctUserList($userId);
                $feedbackName = $userDetail[0]['FIRST_NAME'] . ' ' . $userDetail[0]['LAST_NAME'];
                $feedbackEmail = $userDetail[0]['EMAIL'];
            } else {
                $userId = 0;
                if (!isset($_POST['Name'])) {
                    //header('location: ../view/feedback_form.php');
                    echo "Error Feedback form missing POST details";
                } else {
                    $feedbackName = $_POST['Name'];
                    $feedbackEmail = $_POST['feedbackEmail'];
                }
            }
            $feedbackTitle = $_POST['feedbackTitle'];
            $feedbackNumber = $_POST['feedbackNumber'];
            $feedbackMessage = $_POST['feedbackMessage'];

            fctFeedbackAdd($userId, $feedbackName, $feedbackTitle, $feedbackNumber, $feedbackMessage, $feedbackEmail);
            header('Location: ../view/feedback_form.php');

        }

    } else if ($action == 'feedbackPublish') {

        if (!isset($_POST['feedbackId']) && !isset($_POST['feedbackPublished'])) {
            header('location: ../view/avisClient.php'); //TODO Update target
            echo "Error Feedback form missing POST details";

        } else {
            $feedbackId = $_POST['feedbackId'];
            $feedbackPublished = $_POST['feedbackValue'];

            fctFeedbackSetPublished($feedbackId, $feedbackPublished);
            header('Location: ../view/avisClient.php');

        }

    }elseif ($action == 'feedbackDelete'){
        $target ="avisClient.php";

        if (!isset($_POST['feedbackName']) && !isset($_POST['feedbackId'])) {
            header('location: ../view/avisClient.php');

        } else {
            $ingredientName = $_POST['feedbackName'];
            $feedbackId = $_POST['feedbackId'];

            fctFeedbackDelete($feedbackId);
            header('Location: ../view/avisClient.php');

        }
    }






    else {
        header('Location: ../view/feedback_form.php');
    }


}