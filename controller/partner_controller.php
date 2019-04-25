<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 16:05
 */
session_start();

include_once("../model/partner_model.php");


$target = "partner.php";
if (!isset($_POST['action'])) {
    $target = "partner.php";//PAGE QUAND PAS OK
    echo "Pas d'action";
} else {
    $action = $_POST['action'];

    if ($action == 'partnerAdd') {

        if (isset($_POST['name']) && isset($_POST['description']) && isset($_FILES['image']['tmp_name']) && isset($_POST['link'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $image = file_get_contents($_FILES['image']['tmp_name']);
            $link = $_POST['link'];

            $result = fctPartnerAdd(1, $name, $description, $image, $link, 0);
            $target .= '?id=' . $result;
        }
    } else if ($action == 'partnerEdit') {

        if (isset($_POST['partner_id']) && isset($_POST['name']) && isset($_POST['description']) && isset($_POST['position'])) {
            $id = $_POST['partner_id'];
            $languageId = $_POST['languageId'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $link = $_POST['link'];
            $position = $_POST['position'];

            if (isset($_POST['statut']) && $_POST['statut'] == 'on') {
                $statut=1;
            } else {
                $statut=0;
            }
            fctPartnerEdit($id, $languageId, $name, $description, $link, $position, $statut);
            $target = "partnerEdit.php?id=" . $id;

        }
    } else if ($action == 'partnerEditImage') {

        if (isset($_POST['partner_id']) && isset($_FILES['image']['tmp_name'])) {
            $id = $_POST['partner_id'];
            $image = file_get_contents($_FILES['image']['tmp_name']);

            fctPartnerEditImage($id, $image);
            $target = "partnerEdit.php?id=" . $id;
        }
    } else {
        echo "action inconnue";

    }
}
header("location: ../view/".$target);


?>

<pre> <? print_r($result); ?> </pre>
