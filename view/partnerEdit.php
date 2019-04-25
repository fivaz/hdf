<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 09:47
 */

session_start();
include_once('header.php');
include_once("../model/partner_model.php");

$id = $_GET['id'];

//$listePartenaires = getPartner($id, $siteLanguage);

//if(!isset($_COOKIE['elementLanguage'])){
//    $listePartenaires = getPartner($id, $siteLanguage);
//    echo "1";
//}else{
//    echo "2";
//    $listePartenaires = getPartner($id, $_COOKIE['elementLanguage']);
//}

//get the current language of this element
$languageId = 1;

if(isset($_COOKIE['elementLanguage'])){
    $languageId = $_COOKIE['elementLanguage'];
}

$listePartenaires = getPartner($id, $languageId);


$image = base64_encode($listePartenaires[0]['IMAGE']);
?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <form class="cf1" action="../controller/partner_controller.php" method="post" enctype="multipart/form-data">


                <fieldset>
<!--                    <legend><h1>--><?//=$lang['edit_partner']?><!--</h1></legend>-->
                    <div class="pageTitle"><?=$lang['edit_partner']?></div>
                    <a href="../view/partner.php"><?= $lang['back_partner'] ?></a>
                    <select id="elementLanguage" name="languageId" style="float:right">

                    </select>


                    <input type="text" name="name" id="name" autofocus required size="30" maxlength="40"placeholder="<?=$lang['name']?>"
                           value="<?= $listePartenaires[0]['NAME'] ?>"/><br/>


                    <textarea type="text" name="description" id="DESCRIPTION" size="500" required maxlength="500"placeholder="<?=$lang['description']?>"
                           ><?= $listePartenaires[0]['DESCRIPTION'] ?></textarea><br/>

                    <?php
                    if ($image) { //existing image ?>
                        <img class="imgpreview my-3" src="data:image/jpeg;base64, <?= $image ?>"/>
                    <?php } else { //no image ?>
                        <img class="imgpreview my-3" src="../resources/noimage.png"/>
                    <?php } ?>

                    <button type="button" class="mb-3" data-toggle="modal" data-target="#imageModal">Edit image</button>


                    <input type="text" name="link" id="LINK" size="30" maxlength="40"placeholder="LINK"
                           value="<?= $listePartenaires[0]['LINK'] ?>"><br/>
                    <input type="checkbox" name="statut" id="isactive"
                           <?= $listePartenaires[0]['ISACTIVE']!=1?:"checked";?>
                    <label for="isactive"><?=$lang['enable']?> </label>
                    <input type="hidden" name="action" value="partnerEdit"/>
                    <input type="hidden" name="partner_id" value="<?= $listePartenaires[0]['PART_ID'] ?>"/>
                    <input type="number" name="position" placeholder=" <?=$lang['position']?>" value="<?= $listePartenaires[0]['POSITION'] ?>"/>
                    <button type="submit" value="Modifier"><?=$lang['edit']?></button>


                </fieldset>
            </form>

        </div>
    </div>
</div>

<div id="imageModal" class="modal mt-auto fade">
    <div class="modal-dialog modal-dialog-centered fform">
        <div class="modal-content cf1">

            <form class="cf1" method="post" action="../controller/partner_controller.php" enctype="multipart/form-data">
                <input type="hidden" name="partner_id" value="<?= $id ?>"/>
                <input type="hidden" name="action" value="partnerEditImage"/>

                <div class="modal-header">
                    <h4 id="modalTitle" class="modal-title">Image update</h4>
                </div>

                <div id="modalBody" class="modal-body">
                    <div id="preview" style="vertical-align:middle">
                        <?php if ($image) { ?>
                            <img class="imgpreview " id="imgpreview" src="data:image/jpeg;base64, <?= $image ?>"/>
                        <?php } else { ?>
                            <img class="imgpreview" id="imgpreview" src="../resources/noimage.png"/>
                        <?php } ?>
                    </div>

                    <div class="form-group upload-btn-wrapper my-2">
                        <button type="button" class="btn"><?= $lang['upload_image'] ?></button>
                        <br/>
                        <input type="file" id="browse" name="image"/>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal"><?= $lang['close'] ?></button>
                    <button type="submit" value="Envoyer"><?= $lang['save'] ?></button>
                </div>

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

<script src="../js/imagePreview.js"></script>


<?php include_once('footer.php'); ?>
