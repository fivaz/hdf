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

            <form class="cf1" action=" ../controller/about_controller.php" method="post"
                  enctype="multipart/form-data">

                <fieldset>
                    <legend><h1> <?=$lang['add_thdf']?></h1></legend>

                    <input type="text" name="title" id="TITLE" required autofocus size="30" maxlength="40"
                           placeholder="<?=$lang['title']?>"/><br/>

                    <input type="text" name="description" id="DESCRIPTION" required size="128" maxlength="128"
                           placeholder="<?=$lang['description']?>"><br/>

                    <input name="action" type="hidden" value="aboutAdd"/>
                    <button type="submit" value="Ajouter"><?=$lang['add']?></button>

                </fieldset>

            </form>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>
