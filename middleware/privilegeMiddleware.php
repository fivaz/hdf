<?php
/**
 * Created by PhpStorm.
 * User: Fivaz
 * Date: 29/10/2018
 * Time: 07:26
 */

/*list of sites where the middleware will block*/
$protecteds = array(
    "partnerAdd",
    "parameter",
    "eventAdd",
    "eventEdit",
    "partnerEdit",
    "aboutAdd",
    "aboutEdit",
    "userList",
    "userEdit",
);

/*error message*/
$msg = $lang['privilege_middleware_error_msg'];

foreach($protecteds as $protected)
{
    if(basename($_SERVER["SCRIPT_FILENAME"], ".php") == $protected)
    {
       /*condition when it's not authorized*/
        if($_SESSION['user']['PRIVILEGE']!=1)
        {
            /*page for redirect*/
            header("location: main.php?error-msg=".$msg);
            exit();
        }
    }
}
