<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 11.10.2018
 * Time: 14:19
 */

session_start();
include_once ("../model/user_model.php");

if($_SESSION['user']['PRIVILEGE']==1 && isset($_GET['user'])&& isset($_GET['active']))
{
    $user=$_GET['user'];
    $active=$_GET['active'];

    if ($active==1) {
        fctUserIsActive($user, 1);
    }
    elseif ($active==0)
    {
    fctUserIsActive($user, 0);
    }
}



header('location: userList.php');