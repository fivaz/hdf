<?php
/**
 * Created by PhpStorm.
 * User: Fivaz
 * Date: 29/10/2018
 * Time: 07:26
 */

/*list of sites where the middleware will block*/
$protecteds = array(
    "userProfileEdit"
);

/*error message*/
$msg = $lang['login_middleware_error_msg'];


foreach($protecteds as $protected)
{
    if(basename($_SERVER["SCRIPT_FILENAME"], ".php") == $protected)
    {
        /*condition*/
        if(!isset($_SESSION['user']['USER_ID']))
        {
            /*page for redirect*/
            header("location: main.php?error-msg=".$msg);
            exit();
        }

    }
}
