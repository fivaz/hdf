<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 1.10.2018
 * Time: 16:01
 */
include_once('header.php');

include_once("../model/partner_model.php");
//$imgLogo = base64_encode(fctParameterGet("IMG_LOGO")["VALUE"]);

if (isset($_SESSION['user']['USER_ID']) && $_SESSION['user']['PRIVILEGE'] == 1) {
    $privilege = 1;
} else {
    $privilege = 0;
}

$listePartenaires = fctPartnerList($_COOKIE['siteLanguage']);
//var_dump($listePartenaires);
?>


<link rel="stylesheet" href="partner/partner.css">
<div class="mt-2 mb-5">

    <?php if (isset($_SESSION['user']['USER_ID']) && $_SESSION['user']['PRIVILEGE'] == 1) : ?>
        <i class="fas fa-plus-circle fa-3x float-right text-black " onclick="window.location='partnerAdd.php'"></i>
    <?php endif; ?>

</div>


<div class="container mt-5 ">

    <?php foreach ($listePartenaires

                   as $partenaire) { ?>

        <?php if ($privilege == 0 && $partenaire['ISACTIVE'] != 1) { //client et partenaire désactivé
            //partenaire pas affiché
        } else {
            ?>

            <?php// if ($partenaire['ISACTIVE'] != 1) : // Partenaire pas actif?>

            <div class="ccontainer row mb-5 <?= $partenaire['ISACTIVE'] == 1 ?: 'disabled' ?>">
                <div class="col col-lg-6 d-lg-block d-sm-none d-none mt-1">
                    <div style="position:absolute">

                        <?php if ($partenaire['IMAGE']): ?>

                            <img class="boxed item " onClick="window.location= 'http://<?= $partenaire['LINK'] ?>'"
                                 data-type="image"
                                 src="data:image/jpeg;base64, <?= base64_encode($partenaire['IMAGE']) ?>">
                            <div class="wp1_left wp1_shd"></div>
                            <div class="wp1_right wp1_shd"></div>

                        <?php else: ?>
                            <img src="../resources/noimage.png"/>
                        <?php endif ?>

                    </div>

                </div>

                <div class="col col-lg-6 col-md-9 col-sm-12 mt-1">

                    <div class="partner-header">

                        <h2 onClick="window.location='http://<?= $partenaire['LINK'] ?>'">
                            <strong><?= $partenaire['NAME'] ?></strong></h2>

                        <?php if ($privilege == 1) { ?>

                            <div class=" mr-3">
                                <div class="dropdown dropright float-right">

                                    <i class="fa fa-ellipsis-h fa-2x float-right" data-toggle="dropdown"></i>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="partnerEdit.php?id=<?= $partenaire['PART_ID'] ?>">
                                            <?= $lang['edit'] ?>
                                        </a>

                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>

                    <h6 class="text-justify"><?= $partenaire['DESCRIPTION'] ?></h6>

                </div>

            </div>
            <?php // } ?>

        <?php }
    } ?>


</div>
<script>
    //this is a script that computes the position of the .item based on the height of the .container
    $(function () {
        let y = 0;
        $('.image-container .item').each(function () {
            y = Math.max(y, $(this).height() + $(this).position().top) + 10;
        });

        $('.image-container').css('height', y);
    });
    //this is a script that computes the position of the .item based on the height of the .container
    $(function () {
        let y = 0;
        $('.ccontainer .item').each(function () {
            y = Math.max(y, $(this).height() + $(this).position().top) + 10;
        });

        $('.ccontainer').css('height', y);
    });


    //function fctPartnerDisable() {
    //    <?//=fctPartnerDisable($partenaire['PART_ID'])?>
    //}
    //
    //function fctPartnerEnable() {
    //    <?//=fctPartnerEnable($partenaire['PART_ID'])?>
    //}


</script>

<?php include_once('footer.php'); ?>

