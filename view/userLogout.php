<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 11.10.2018
 * Time: 14:19
 */

session_start();
$_SESSION = array();
session_destroy();

header('location: main.php');