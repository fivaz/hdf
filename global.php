<?php

spl_autoload_register('loadClass');

if(!isset($_SESSION)){
    session_start();
}

function loadClass($className)
{
    $modelPath = __DIR__."/model/";
    $controllerPath = __DIR__."/controller/";

    if (file_exists($modelPath .$className . '.php')) {
        require_once($modelPath . $className . '.php');
    }
    elseif (file_exists($controllerPath . $className . '.php'))
    {
        require_once($controllerPath .$className . '.php');
    }
    else
    {
        echo "ERROR IMPORTING </br> ";
        echo $modelPath. $className.".php";
        echo " </br> or </br>";
        echo $controllerPath .$className . ".php";
        //header("Location: ".$modelPath. $className.".php");
    }
}

//this system can be improved

$siteLanguage = 1;

if(isset($_COOKIE["siteLanguage"])) {
    $siteLanguage = $_COOKIE["siteLanguage"];
}

switch($siteLanguage){
    case 2:
        require_once(__DIR__."/resources/lang_EN.php");
        break;
    default:
        require_once(__DIR__."/resources/lang_FR.php");
        break;
}

/*import middlewares*/

require_once(__DIR__."/middleware/loginMiddleware.php");

require_once(__DIR__."/middleware/privilegeMiddleware.php");

