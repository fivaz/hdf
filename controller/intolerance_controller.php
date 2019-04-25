<?php
/**
 * Created by PhpStorm.
 * User: Frank
 * Date: 01/10/2018
 * Time: 20:51
 */

include_once('../model/foodintolerance_model.php');


//Add an intolerance in the database
if (!isset($_POST['intoleranceName'])) {
//    header('location: ../view/contact.php');

} else {
    $intoleranceName = $_POST['intoleranceName'];
    fctFoodintoleranceAdd(1,$intoleranceName);
    header('Location: ../view/intolerance.php');
}

