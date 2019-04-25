<?php
/**
 * Site parameters page
 * User: THEODOLOZ_FRANK-ESIG
 * Date: 28.09.2018
 * Time: 11:16
 */

include_once("../model/parameter_model.php");
include_once("header.php");

$imgLogo = base64_encode(fctParameterGet("COMPANY_LOGO"));

?>

<div class="container mt-5">
    <div class="row">
        <div class="col col-lg-6 col-md-8 col-12 centered">

            <div class="pageTitle"><?= $lang["parameters"] ?></div>

            <form class="cf1" method="post" action="../controller/parameter_controller.php">
                <fieldset class="form-group">
                    <legend class="pageSubTitle"><?= $lang["company_details"] ?></legend>
                    <div class="form-group">
                        <input type="text" name="COMPANY_NAME" placeholder="COMPANY NAME"
                               value="<?= fctParameterGet("COMPANY_NAME") ?>"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="CONTACT_PHONE" placeholder="FORMAT INTERNATIONAL: + 41 (0)76 000 00 00"
                               value="<?= fctParameterGet("CONTACT_PHONE") ?>"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="ADDRESS1" placeholder="ADDRESS"
                               value="<?= fctParameterGet("ADDRESS1") ?>"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="ADDRESS2" placeholder="POSTAL CODE"
                               value="<?= fctParameterGet("ADDRESS2") ?>"/>
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <legend class="pageSubTitle"><?= $lang["social_media"] ?></legend>
                    <div class="form-group">
                        <input type="text" name="LINK_TWITTER" value="<?= fctParameterGet("LINK_TWITTER") ?>"
                               placeholder="TWITTER LINK"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="LINK_TRIPADVISOR" value="<?= fctParameterGet("LINK_TRIPADVISOR") ?>"
                               placeholder="TRIPADVISOR LINK"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="LINK_INSTAGRAM" value="<?= fctParameterGet("LINK_INSTAGRAM") ?>"
                               placeholder="INSTAGRAM LINK"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="LINK_FACEBOOK" value="<?= fctParameterGet("LINK_FACEBOOK") ?>"
                               placeholder="FACEBOOK LINK"/>
                    </div>
                    <input type="hidden" name="action" value="updateDetails"/>
                    <button type="submit" value="submit"><?= $lang['save'] ?></button>
                </fieldset>
            </form>

            <form class="cf1" method="post" action="../controller/parameter_controller.php" enctype="multipart/form-data">
                <fieldset class="form-group">
                    <legend class="pageSubTitle bordered"><?= $lang["logo"] ?></legend>

                    <div class="imgpreview" id="preview" style="vertical-align:middle">
                        <?php if ($imgLogo) { ?>
                            <img id="imgpreview" src="data:image/jpeg;base64, <?= $imgLogo ?>"/>
                        <?php } else { ?>
                            <img id="imgpreview" src="../resources/noimage.png"/>
                        <?php } ?>
                    </div>

                    <input type="hidden" id="imagePath" name="imagePath" value=""/>
                    <div class="form-group upload-btn-wrapper">
                        <button class="btn"><?= $lang['upload_image'] ?></button>
                        <input type="file" id="browse" name="logo"/>
                    </div>
                    <input type="hidden" name="action" value="updateLogo"/>
                    <button type="submit" id="sendImage" value="Changer Logo" disabled><?= $lang['save'] ?></button>
                </fieldset>
            </form>

            <form class="cf1">
                <fieldset class="form-group">
                    <legend class="pageSubTitle bordered"><?= $lang["contact_email"] ?></legend>
                    <div class="form-group">
                        <input type="email" name="CONTACT_EMAIL" placeholder="EMAIL@EXAMPLE.COM"
                               value="<?= fctParameterGet("CONTACT_EMAIL") ?>" disabled/>
                    </div>
                    <button type="button" class="btn cf1" data-toggle="modal" data-target="#parameterModal"><?= $lang['change'] ?></button>
                </fieldset>
            </form>

        </div>
    </div>
</div>

<div id="parameterModal" class="modal mt-auto fade">
    <div class="modal-dialog modal-dialog-centered fform">
        <div class="modal-content cf1">

            <div class="modal-header">
                <h2 id="modalTitle" class="modal-title"><?= $lang['contact_email_change_title'] ?></h2>
            </div>

            <div id="modalBody" class="modal-body">

                <form class="cf1" method="post" action="../controller/parameter_controller.php">

                    <div class="form-group">
                        <input type="email" name="CONTACT_EMAIL" placeholder="EMAIL@EXAMPLE.COM" value="<?= fctParameterGet("CONTACT_EMAIL") ?>" required autofocus/>
                        <div class="fieldnote"><?= $lang['contact_email_change'] ?></div>
                        <input type="hidden" name="action" value="contactEmailChange"/>
                        <button id="submitButton" type="submit"><?= $lang['save'] ?></button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="cf1" data-dismiss="modal"><?= $lang['cancel'] ?></button>
            </div>
        </div>
    </div>
</div>

<script src="../js/imagePreview_param.js"></script>

<?php include_once("footer.php"); ?>
