<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 09:47
 */

include_once('header.php');

?>


<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <form class="cf1" action="../controller/partner_controller.php" method="post" enctype="multipart/form-data">

                <fieldset>
                    <legend><h1><?=$lang['add_partner']?></h1></legend>


                    <input type="text" name="name" id="NAME" required placeholder="<?=$lang['name']?>"  autofocus size="30"
                           maxlength="40"/><br/>


                    <textarea name="description" id="DESCRIPTION" size="500" maxlength="500"
                              required placeholder="<?=$lang['description']?>"></textarea><br/>

                    <div class="imgpreview" id="preview" style="vertical-align:middle">
                        <img id="imgpreview" src="../resources/noimage.png"/>
                    </div>

                    <input type="hidden" id="imagePath" name="imagePath" value=""/>
                    <div class="form-group upload-btn-wrapper">
                        <button class="btn"><?= $lang['upload_image'] ?></button>
                        <input type="file" id="browse" name="image"/>
                    </div>

<!--                    <input class="form-control-file " style="image"  type="file" name="image" /><br/>-->


                    <input type="text" name="link" id="LINK" size="128" maxlength="128"placeholder="LINK"><br/>
                    <input name="action" type="hidden" value="partnerAdd"/>
                    <button type="submit" value="Ajouter"><?=$lang['add']?></button>

                </fieldset>

            </form>
        </div>
    </div>
</div>

<script src="../js/imagePreview.js"></script>

<?php include_once('footer.php'); ?>
