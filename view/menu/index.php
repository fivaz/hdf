<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 04.10.2018
 * Time: 16:28
 */

require_once("../layout/header.php");

$admin = 0;

if(isset($_SESSION['user']['PRIVILEGE']))
{
    $admin = $_SESSION['user']['PRIVILEGE'];
}

?>

<!-- menu css -->
<link rel="stylesheet" href="css/modal.css">
<link rel="stylesheet" href="css/all.css">
<link rel="stylesheet" href="css/article.css">
<link rel="stylesheet" href="css/category.css">

<main id="menu">

    <input id="lang" type="hidden" value="<?=$siteLanguage?>">

    <input id="admin" type="hidden" value="<?=$admin?>">

    <h1><?=$lang["menu_title"]?></h1>

    <p>

        <?=$lang["menu_text1"]?>
        </br>
        <?=$lang["menu_text2"]?>
        </br>
        <?=$lang["menu_text3"]?>
        </br>

    </p>

    <section id="highlight">

    </section>

    <div id="categories">

    </div>

    <?php if($admin == 1):?>

        <div class="btn-footer">

            <button id="add-category" type='button' class='myBtn' data-toggle='modal' data-target='#modalCategory1'>
    <!--            Add Category-->
                <?=$lang['category_create']?>
            </button>

            <button id="add-article" type="button" class="myBtn" data-toggle="modal" data-target="#exampleModal1" data-whatever="@getbootstrap">
    <!--            Add Article-->
                <?=$lang['article_create']?>
            </button>

        </div>

    <?php endif ?>

</main>

<script src="js/all.js"></script>
<script src="js/category.js"></script>
<script src="js/article.js"></script>
<script src="js/load.js"></script>

<?php require_once("../layout/footer.php"); ?>
