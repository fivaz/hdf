<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 09:13
 */


include_once('header.php');
include_once("../model/user_model.php");

$userId=$_GET['id'];
$privilege = $_SESSION['user']['PRIVILEGE'];
$userList = fctUserList($userId);
if( $_SESSION['user']['PRIVILEGE']==1 OR $_POST['privilege']=="admin"){
    $privilege=1;
}
else[
    $privilege=0];

fctUserSetPrivilege($userId,$privilege);

?>

<div class="row">

    <div class="container center col-5">

        <div class="fform">


            <form class="cf1" action="../controller/user_controller.php" method="post" >

                <fieldset>
                    <legend><h1><?= $lang['edit_user'] ?></h1></legend>

                    <input type="text" name="lastname" id="LAST_NAME" required autofocus size="30" maxlength="40"
                           value="<?= $userList[0]['LAST_NAME'] ?>" placeholder="<?= $lang['lastname'] ?>"><br/>

                    <input type="text" name="firstname" id="FIRST_NAME" required size="30" maxlength="40"
                           value="<?= $userList[0]['FIRST_NAME'] ?>" placeholder="<?= $lang['firstname'] ?>"><br/>

                    <input type="email" name="email" required size="30" maxlength="40"
                           value="<?= $userList[0]['EMAIL'] ?>" placeholder="<?= $lang['email'] ?>"><br/>

                    <input type="checkbox" id="admin"
                           name="privilege" value="1" >
                    <label for="admin"><?= $lang['admin'] ?></label>

                    <input type="checkbox" id="client"
                           name="privilege" value="0">
                    <label for="client"><?= $lang['customer'] ?></label>

                    <input type="hidden" name="user_id" required size="30" maxlength="40" value="<?= $userId ?>"><br/>
                    <input type="hidden" name="action" value="userEdit">
                    <button type="button" value="Reset mot de passe" style="float: left;" onclick="window.location.href='userPasswordReset.php'"><?= $lang['password_change'] ?></button> <!-- onclick???-->
                    <button type="button" value="RetourUserEdit" style="float:none  " onclick="window.location.href='userList.php'"><?= $lang['return_list'] ?></button> <!-- onclick???-->
                    <button type="submit" value="Enregistrer" style="float: right;"><?= $lang['save'] ?></button>
                </fieldset>
            </form>
        </div>
    </div>
</div>
<script>
    if(document.getElementById('admin').checked){
        // it is checked. Do something

       <?php fctUserSetPrivilege($userId,1) ?>
    }
    else if(document.getElementById('client').checked)
    {
        <?php fctUserSetPrivilege($userId,0) ?>
    }
</script>

<?php include_once('footer.php'); ?>
