<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 16:05
 */
session_start();
include_once("../global.php");
include_once("../model/user_model.php");

function isStrong1($password)
{
    $uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    $lowercase = "abcdefghijklmnopqrstuvwxyz";

    $digits = "0123456789";

    $ucaseFlag = contains1($password, $uppercase);

    $lcaseFlag = contains1($password, $lowercase);

    $digitsFlag = contains1($password, $digits);

    if (intval(strlen($password)) >= 8 && $ucaseFlag && $lcaseFlag && $digitsFlag)
        return true;
    else
        return false;
}


function contains1($password_str, $allowedChars)
{
    $password_array = str_split($password_str);

    foreach($password_array as $lettre) {

        if (strpos($allowedChars, $lettre)) {
            return true;
        }
    }
  
  	echo($allowedChars);
    return false;
}

$target = "main.php";
if (!isset($_POST['action'])) {
    echo "invalid form";

} else {
    $action = $_POST['action'];

    if ($action == 'login') {
        $target = "userProfileEdit.php";
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = strtolower($_POST['email']);
            $password = $_POST['password'];

            $user = fctUserFindEmail($email);//si le mail existe

            if ($user) {
                if (!$user['ISACTIVE']) {
                    $target = "main.php?error-msg=." . $lang['acount_disabled'];
                } else {
                    if (password_verify($password, $user['PASSWORD_HASH'])) {
                        $_SESSION['user']['USER_ID'] = $user['USER_ID'];
                        $_SESSION['user']['FIRST_NAME'] = $user['FIRST_NAME'];
                        $_SESSION['user']['LAST_NAME'] = $user['LAST_NAME'];
                        $_SESSION['user']['EMAIL'] = $user['EMAIL'];
                        $_SESSION['user']['PRIVILEGE'] = $user['PRIVILEGE'];
                        //$_SESSION['user']['PRIVILEGE'] = 1;

                        $target = "main.php";
                    } else {
                        $target = "main.php?error-msg=" . $lang['access_denied']; //problème mdp
                    }
                }

            } else {
                $target = "main.php?error-msg=" . $lang['access_denied']; //problème email pas trouvé
            }
            header("location: ../view/" . $target);
        }

    } elseif ($action == 'register') {
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['firstname']) && isset($_POST['lastname'])) {
            $email = strtolower($_POST['email']);
            $password = $_POST['password'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $isactive = 1;

		  //$user = fctUserFindEmail($email);//si le mail existe

		  $user = false;
		  
		  if(isStrong1($password)){
			
			die("strong");
			
		  }else{
			
			die("pas strong");
		  
		  }
			
            if ($user) {
                $target = "userAdd.php?error-msg=" . $lang['email_used'];
            } else {
                $_SESSION['user']['USER_ID'] = $user['USER_ID'];
                $_SESSION['user']['FIRST_NAME'] = $user['FIRST_NAME'];
                $_SESSION['user']['LAST_NAME'] = $user['LAST_NAME'];
                $_SESSION['user']['EMAIL'] = $user['EMAIL'];
                $_SESSION['user']['PRIVILEGE'] = $user['PRIVILEGE'];

                $result = fctUserAdd($lastname, $firstname, $email, $password, $isactive);
                $target = "main.php";
			  header("location: ../view/" . $target);
            }

        }else{
			
			header("location: http://wwww.facebook.com");
		  }
    } elseif ($action == 'editDetails') {
        if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $id = $_POST['user_id'];

            $result = fctUserEditDetails($id, $lastname, $firstname);

            $target = "userProfileEdit.php";
            $target .= '?id=' . $result;
            echo $result;
            header("location: ../view/" . $target);
        }


    } elseif ($action == 'passwordChange') { //Edit Frank

        if (isset($_POST['password'])) {
            $password = $_POST['password'];
            $id = $_SESSION['user']['USER_ID'];

            $result = fctUserEditPassword($id, $password);

            $target = "userProfileEdit.php";
        }
        header("location: ../view/" . $target);

    } elseif ($action == 'passwordReset') { // Frank cherche si l'email est juste et envoie le mail+token

        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            $emailFound = fctUserFindEmail($email);

            if (!$emailFound) {
                header("location: ../view/userPasswordReset.php?error-msg=" . $lang['email_not_found']);
            } else {
                $email = $emailFound['EMAIL'];
                include_once('token_controller.php');
            }
        }
        header("location: ../view/" . $target);


    } elseif ($action == 'passwordResetProcess') { // Frank

        if (isset($_POST['token']) && isset($_POST['password'])) {
            $token = $_POST['token'];
            $password = $_POST['password'];

            include_once('../model/token_model.php');

            $tokenDetails = fctTokenDetail($token);
            $email = $tokenDetails['VALUE'];

            $userDetail = fctUserFindEmail($email);
            $userId = $userDetail['USER_ID'];
            $result=fctUserEditPassword($userId,$password);

            if($result == 1 ){
                header("location: ../view/main.php?success-msg=Changement du mot de passe réussi.");

            } else{
                header("location: ../view/main.php?error-msg=Le changement du mot de passe a échoué.");

            }

        }

    } elseif ($action == 'editEmail') {

        if (isset($_GET['id']) && isset($_POST['email'])) {
            $email = $_POST['email'];
            $id = $_GET['id'];

            $result = fctUserEditEmail($id, $email);
            $target = "main.php";
            $target .= '?id=' . $id;
            header("location: ../view/" . $target);
        }



    } elseif ($action == 'userEdit') {
        if (isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['privilege'])) {
            $email = strtolower($_POST['email']);
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $privilege = $_POST['privilege'];
            $id = $_POST['user_id'];
            $result = fctUserEdit($id, $lastname, $firstname, $email, $privilege);
            $target = "userEdit.php";
            $target .= '?id=' . $id;
            echo $result;
            header("location: ../view/" . $target);
        }
    }

}


//header("location: ../view/" . $target); //TODO CHECK IF NEEDED HERE !!! (password reset redirect issue)

?>

<pre><? print_r($result); ?> </pre>