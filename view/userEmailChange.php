<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 09:47
 */

include_once('header.php');
include_once('../model/user_model.php');

?>
<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <form class="cf1" action="../controller/user_controller.php" method="post">
                <fieldset>
                    <legend><h1><?=$lang['email_change_Form']?></h1></legend>

                    <input type="email" name="email" id="email" placeholder="<?=$lang['email']?>" required
                           size="30"
                           maxlength="40"><br/>
                    <input name="action" value="editEmail" type="hidden"/>
                    <button type="submit" value="envoyer"><?=$lang['send']?></button>

                </fieldset>

            </form>

        </div>
    </div>
</div>