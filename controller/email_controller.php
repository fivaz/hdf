<?php
/**
 * Email controller for sending emails
 * User: Frank
 * Date: 22/10/2018
 * Time: 12:24
 */

include_once('../global.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//function fctSendMail($to, $recipientName, $subject, $body)
function fctSendMail($to, $subject, $body)
{
    //https://github.com/PHPMailer/PHPMailer
    require('../bin/PHPMailer/src/PHPMailer.php');
    require('../bin/PHPMailer/src/Exception.php');
    require('../bin/PHPMailer/src/SMTP.php');

    $senderName = "The Hot Dog Faktory";
    $from = 'no-reply@thehotdogfaktory.com';
    $mail = new PHPMailer(TRUE);
    $mail->CharSet = "UTF-8";

    try {
        $mail->SMTPDebug = 0;               // Enable verbose debug output
        $mail->isSMTP();                    // Set mailer to use SMTP
        $mail->Host = EMAIL_SERVER;         // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;             // Enable SMTP authentication
        $mail->Username = EMAIL_ACCOUNT;    // SMTP username
        $mail->Password = EMAIL_PASSWORD;   // SMTP password
        $mail->SMTPSecure = 'tls';          // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                  // TCP port to connect to

        $mail->setFrom($from, $senderName);
//        $mail->addAddress($to, $recipientName);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $body;

        if (!$mail->send()) {
            echo 'Email was not sent.';
            echo 'Mailer error: ' . $mail->ErrorInfo;
        } else {
            echo 'Email sent.';
        }

    } catch (Exception $e) {
        echo $e->errorMessage();
    } catch (\Exception $e) { //when catching an exception inside a namespace it is important that you escape to the global space
        echo $e->getMessage();
    }
}