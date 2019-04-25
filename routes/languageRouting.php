<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 10.10.2018
 * Time: 17:01
 */

include_once(dirname(__DIR__) . "/global.php");

if(isset($_GET['method']) && $_GET['method'] == "getLanguages")
{
    $languageController = new LanguageController();
    echo $languageController->loadLanguages();
}
elseif(isset($_GET['method']) && $_GET['method'] == "getSiteLang"){
    echo json_encode($lang);
}
else
{
    echo "routing failed";
}

