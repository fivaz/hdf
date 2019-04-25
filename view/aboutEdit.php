<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 09:47
 */

session_start();
include_once('header.php');
include_once("../model/about_model.php");

$id = $_GET['id'];
//$listeAbout = fctAboutList($_COOKIE['elementLanguage'], $id);

if(!isset($_COOKIE['elementLanguage'])){
  $listeAbout = getAbout($id, $_COOKIE['siteLanguage']);
}else{
    $listeAbout = getAbout($id, $_COOKIE['elementLanguage']);
}
$languageId = $_COOKIE['elementLanguage'];
$listeAbout=getAbout($id,$languageId);
var_dump(  $listeAbout[0]['ISACTIVE']);

?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <form class="cf1" action="../controller/about_controller.php" method="post">

                <fieldset>
                    <div class="pageTitle"><?=$lang['edit_thdf']?></div>
                    <a href="../view/about.php"><?= $lang['back_thdf'] ?></a>

                    <select id="elementLanguage" name="languageId" style="float:right">

                    </select>


                    <input type="text" name="title" id="title" required autofocus maxlength="128"
                           value="<?= $listeAbout[0]['TITLE'] ?>" placeholder="<?=$lang['title']?>"><br/>

                    <textarea name="description" id="DESCRIPTION" required  maxlength="256" placeholder="<?=$lang['description']?>"
                              ><?= $listeAbout[0]['DESCRIPTION'] ?> </textarea><br/>

                    <input type="hidden" name="about_id" value="<?= $listeAbout[0]['ABOU_ID'] ?>"/>

                    <input type="checkbox" name="statut" id="isactive"
                    <?= $listeAbout[0]['ISACTIVE']!=1?:"checked";?>
                    <label for="isactive"><?=$lang['enable']?> </label>

                    <input type="number" name="position" placeholder="<?=$lang['position']?>" value="<?= $listeAbout[0]['POSITION'] ?>"/>

                    <input type="hidden" name="id" value="<?= $listeAbout[0]['ABOU_ID'] ?>"/>

                    <input type="hidden" name="action" value="aboutEdit">
                    <button type="submit" value="Modifier"><?=$lang['edit']?></button>

                </fieldset>

            </form>
        </div>
    </div>
</div>

<script>

    $(function() {

        let select = $("#elementLanguage");

        buildLanguageSelect(select, "elementLanguage");

        checkLanguageSelect(select, "elementLanguage", getCookie("siteLanguage"));

    });
</script>

<?php include_once('footer.php'); ?>
