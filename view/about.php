<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 1.10.2018
 * Time: 16:01
 */

session_start();
include_once('header.php');
include_once("../model/about_model.php");

if (isset($_SESSION['user']['USER_ID']) && $_SESSION['user']['PRIVILEGE'] == 1) {
    $privilege = 1;
} else {
    $privilege = 0;
}
$aboutList = fctAboutList($_COOKIE['siteLanguage']);
?>
<link rel="stylesheet" href="../bin/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" href="about/about.css">

<div class="mt-2 mb-5 ">

    <?php if (isset($_SESSION['user']['USER_ID']) && $_SESSION['user']['PRIVILEGE'] == 1) : ?>

        <i class="fas fa-plus-circle fa-3x float-right text-black" onclick=window.location="aboutAdd.php"></i>

    <?php endif?>

</div>

<div class="container mt-5">

    <div class="ccontainer row mb-5">

        <div class="col col-lg-6 d-lg-block d-sm-none d-none mt-1 ">

            <div class="image-container mb-4" style="margin-bottom:60px">
                <img class="boxed item" src="../resources/about/about1.png" >
                <!--                <div class="wp1_left wp1_shd"></div>-->
                <!--                <div class="wp1_right wp1_shd"></div>-->
            </div>

            <div class="mb-5">
                <img class="boxed item" src="../resources/about/about2.png">
            </div>

        </div>


        <div class="col col-lg-6 col-md-9 col-sm-12 mt-1">

            <?php foreach ($aboutList as $about): ?>

            <?php if ($privilege == 0 && $about['ISACTIVE'] != 1) {
                //About pas affiché
            } else {

            ?>
            <?php if($about['ISACTIVE'] != 1): ?>
                <div class="grey">
            <?php else: ?>
                <div>
            <?php endif ?>
                <div class="about-header">

                    <h2><strong><?= $about['TITLE'] ?></strong></h2>

                    <?php if (isset($_SESSION['user']['USER_ID']) && $_SESSION['user']['PRIVILEGE'] == 1) : ?>

                        <div class="mr-3">

                            <div class="dropdown dropright float-right">

                                <i class="fa fa-ellipsis-h fa-2x" data-toggle="dropdown"></i>

                                <div class="dropdown-menu">

                                    <a class="dropdown-item"
                                       href="aboutEdit.php?id=<?= $about['ABOU_ID'] ?>">
                                        <?=$lang['edit']?></a>

                                </div>

                            </div>

                        </div>

                    <?php endif ?>

                </div>

                <p class="text-justify"><?= $about['DESCRIPTION'] ?></p>


                </div>
                <?php } ?>
            <?php endforeach ?>


    </div>

    </div>

</div>
<script>
    //this is a script that computes the position of the .item based on the height of the .container
    $(function () {
        let y = 0;
        $('.ccontainer .item').each(function () {
            y = Math.max(y, $(this).height() + $(this).position().top) + 10;
        });

        $('.ccontainer').css('height', y);
    });
</script>

<script>
    //this is a script that computes the position of the .item based on the height of the .container
    $(function () {
        let y = 0;
        $('.image-container .item').each(function () {
            y = Math.max(y, $(this).height() + $(this).position().top) + 10;
        });

        $('.image-container').css('height', y);
    });
</script>





<?php //include_once('footer.php') ?>
