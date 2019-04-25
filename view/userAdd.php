<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 09:47
 */

session_start();
include_once('header.php');

?>

<!-- Google ReCaptcha (requires #recaptcha div and #submitButton)-->
<script src="../js/recaptcha_load.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

<div class="container center col-6">

    <div class="fform validatedForm">
        <form class="cf1" id="signup-form" action="../controller/user_controller.php" method="post">

            <fieldset>
                <legend><h1><?=$lang['signup_form']?></h1></legend>

                <input type="text" name="lastname" placeholder="<?=$lang['lastname']?>" maxlength="128" required autofocus/>

                <input type="text" name="firstname" placeholder="<?=$lang['firstname']?>" maxlength="128" required/>

                <input type="email" name="email" placeholder="<?=$lang['email']?>" maxlength="128" required>

                <input type="password" name="password" id="password" placeholder="<?=$lang['password']?>" required>


                <input type="hidden" name="action" value="register"/>
                <div id="g-recaptcha"></div>
                <button type="submit" id="submitButton" class="pure-button pure-button-primary" value="S'enregistrer"><?=$lang['register']?></button>

            </fieldset>

        </form>
    </div>
</div>

<?php include_once('footer.php'); ?>
<script>
    // var password = document.getElementById("password")
    //     , confirm_password = document.getElementById("confirm_password");
    //
    // function validatePassword(){
    //     if(password.value != confirm_password.value) {
    //         confirm_password.setCustomValidity("Passwords Don't Match");
    //     } else {
    //         confirm_password.setCustomValidity('');
    //     }
    // }
    //
    // password.onchange = validatePassword;
    // confirm_password.onkeyup = validatePassword;



    // function checkPassword() {
    //     var pwd = $("#inputPwd1").val();
    //     var pwdCheck = $("#inputPwd2").val();
    //
    //     if (pwd != pwdCheck) {
    //         $("#inputPwd2").addClass("is-invalid");
    //         $("#btnPwdSubmit").prop("disabled", true);
    //
    //     } else {
    //         $("#inputPwd2").removeClass("is-invalid");
    //         $("#btnPwdSubmit").prop("disabled", false);
    //     }
    // }
    //
    // $(document).ready(function () {
    //     // $("#btnPwdSubmit").prop("disabled", true);
    //     $("#inputPwd2").keyup(checkPassword);
    //     $("#inputPwd1").keyup(checkPassword);
    //     $("#modalPwdChange").on("show.bs.modal", function () {
    //         $("#frmPwdChange")[0].reset();
    //         $("#inputPwd2").removeClass("is-invalid");
    //         // $("#btnPwdSubmit").prop("disabled", true);
    //     })
    // });

</script>
