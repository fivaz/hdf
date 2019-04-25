<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 16:05
 */
session_start();

include_once("../model/about_model.php");


$target="about.php" ;
if (!isset($_POST['action'])) {
    $target="about.php";//PAGE QUAND PAS OK
    echo "Pas d'action";
} else {
    $action = $_POST['action'];

    if ($action == 'aboutAdd') {
        if (isset($_POST['title']) && isset($_POST['description'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $result = fctAboutAdd(1, $title, $description, 0);
            $target .= '?id=' . $result;
        }

    } elseif ($action == 'aboutEdit') {


        if (isset($_POST['title']) && isset($_POST['description']))  {


            $id=$_POST['about_id'];
            $languageId = $_POST['languageId'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $position=$_POST['position'];

            if (isset($_POST['statut']) && $_POST['statut'] == 'on') {
                $statut=1;
            } else {
                $statut=0;
            }

            $result = fctAboutEdit($languageId, $id, $title, $description, $position, $statut);

            $target = "aboutEdit.php?id=".$id;
        }
    }
}
header("location: ../view/".$target);


?>

<pre> <? print_r($result); ?> </pre>
