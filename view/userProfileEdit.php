<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 09:47
 */

include_once('header.php');
include_once('../model/user_model.php');

$userId = $_SESSION['user']['USER_ID'];

$userDetails = fctUserList($userId);

?>
<div class="row">

    <div class="container center col-6">

        <div class="fform">

            <form class="cf1" action="../controller/user_controller.php" method="post">

                <fieldset>
                    <legend><h1><?=$lang['personal_details']?></h1></legend>


                    <input type="text" name="lastname" id="LAST_NAME" required placeholder=" <?=$lang['lastname']?> " autofocus
                           value="<?= $userDetails[0]['LAST_NAME'] ?>" size="30" maxlength="40"/><br/>


                    <input type="text" name="firstname" id="FIRST_NAME" required placeholder="<?=$lang['firstname']?>"
                           value="<?= $userDetails[0]['FIRST_NAME'] ?>" size="30" maxlength="40"/><br/>


                    <input type="email" id="EMAIL" required placeholder="<?=$lang['email']?>" disabled
                           value=" <?= $userDetails[0]['EMAIL'] ?>" size="30" maxlength="40"><br/>
                    <input type="hidden" name="user_id" value="<?= $userDetails[0]['USER_ID'] ?>"/>
                    <button style="float:left" type="button" value="Changer mot de passe"
                            onclick="window.location.href='userPasswordChange.php'"><?=$lang['password_change']?>
                    </button>
                   
                    <input type="hidden" name="action" value="editDetails"/>
                    <button type="submit"><?=$lang['save']?></button>

                </fieldset>

            </form>

            <form class="cf1" action="../controller/user_controller.php" method="post">
                <fieldset>
                    <legend><h1><?=$lang['intolerances_user']?></h1></legend>

                    <p><?=$lang['intolerances_description']?></p>
                    <?php


                    try {
                        $db = new myPDO();

                        $sql = $db->prepare("Select * from INGREDIENT join INGR_LANG_TEXT ilt on INGREDIENT.INGR_ID = ilt.INGR_ID");
                        $sql->execute();
                        $nombreEnregistrements = $sql->rowCount();

                        if ($nombreEnregistrements > 0) {

                            $sql->setFetchMode(PDO::FETCH_BOTH);

                            while ($donnees = $sql->fetch()) {
                                $nomIntolerance = $donnees['NAME'];
                                ?>


                                <input type="checkbox" name="intolerances" id="intolerances"/>
                                <label for="intolerances"><?php echo $nomIntolerance ?></label><br/> <br/>


                                <?php

                            }

                            $bdd = NULL; // Déconnexion de MySQL
                        }


                    } catch (PDOException $e) {
                        echo "Erreur !: " . $e->getMessage() . "<br />";
                        die();
                    }

                    ?>

                    <button type="submit" value="Enregistrer"><?=$lang['save']?></button>
                </fieldset>

            </form>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>

