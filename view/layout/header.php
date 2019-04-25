<!DOCTYPE html>
<html lang="fr">
<?php
/**
 * Header file with css js calendar and nav menu
 * User: Frank Théodoloz
 * Date: 08/10/2018
 * Time: 21:40
 */

include_once(dirname(__DIR__) . "/../global.php");
include_once('../../model/parameter_model.php');
$imgLogo = base64_encode(fctParameterGet("COMPANY_LOGO"));
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- 0: Google font-->
    <link href="https://fonts.googleapis.com/css?family=Enriqueta" rel="stylesheet">

    <!-- 1: css bootstrap 4.1.3 -->
    <link rel="stylesheet" href="../../css/bootstrap.css"/>
    <!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"-->
    <!--          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"-->
    <!--          crossorigin="anonymous">-->

    <!-- 2: jquery 3.3.1 -->
    <script src="../../js/jquery-3.3.1.js"></script>
    <!--    <script src="https://code.jquery.com/jquery-3.3.1.min.js"-->
    <!--            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"-->
    <!--            crossorigin="anonymous"></script>-->

    <!-- 2.5: jquery ui 1.12 -->
    <script
            src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
            integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
            crossorigin="anonymous"></script>

    <!-- 3: fontawesome 5.3.1 -->
    <link rel="stylesheet" href="../../css/all.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
          crossorigin="anonymous">

    <!-- 4: popper 1.14.3 -->
    <script src="../../js/popper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>

    <!-- 5: js bootstrap 4.1.3 -->
<!--    <script src="../../js/bootstrap.js"></script>-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>

    <!-- bootstrap 4.1.3 without glyphicons -->
    <!--    <link rel="stylesheet" href="../css/bootstrap.min.css">-->
    <!-- only glyphicons -->
    <!--    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">-->


    <!-- 6: custom stylesheet -->
    <link rel="stylesheet" href="../../css/style.css"/>

    <title>SWISS PREMIUM HOT DOG</title>

</head>

<body class="container">

<div class="header-head">

    <aside class="side-panel">

    </aside>

    <!--<img id="logo" src="../resources/logo.png" alt="logo HOT DOG FAKTORY, EST 2013" onclick="location.href='main.php'">-->
    <img id="logo" src="data:image/jpeg;base64,<?= $imgLogo ?>" alt="logo" onclick="location.href='../main.php'">

    <aside class="side-panel">

        <form class="cf1">
            <select id="siteLanguage" title="language" class="m-1">
            </select>
        </form>

        <div class="m-1" id="user">

            <?php
            if (!isset($_SESSION['user']['USER_ID'])) { //user not logged ?>

                <a class="m-1" href="#" data-toggle="modal" data-target="#loginModal"><?= $lang['login'] ?></a>
                <a class="m-1" href="../userAdd.php"><?= $lang['signup'] ?></a>

            <?php } else { //user logged ?>

                <a class="m-1"
                   href="../userProfileEdit.php"><?= $_SESSION['user']['FIRST_NAME'] . ' ' . $_SESSION['user']['LAST_NAME'] ?></a>
                <a class="m-1" href="../userLogout.php"><i class="fa fa-sign-out-alt" aria-hidden="true"></i></a>

                <?php if ($_SESSION['user']['PRIVILEGE'] == 1) { //user with privilege ?>

                    <div class="dropdown" style="display:inline">

                        <i class="fa fa-cog" data-toggle="dropdown"></i>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="../parameter.php"> <?= $lang['site_parameter'] ?></a>
                            <a class="dropdown-item" href="../avisClient.php"><?= $lang['customer_reviews'] ?></a>
                            <a class="dropdown-item" href="../userList.php"><?= $lang['users'] ?></a>
                        </div>
                    </div>

                <?php } ?>

            <?php } ?>

        </div>

    </aside>

</div>

<nav class="navbar-expand-lg">
    <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link" href="../about.php"><?= $lang['about'] ?></a>
        </li>

        <?php if(isset($_SESSION['user']['PRIVILEGE']) && $_SESSION['user']['PRIVILEGE'] == 1): //user not logged ?>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    <?= $lang['menu'] ?>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="../menu"><?= $lang['menu'] ?></a>
                    <a class="dropdown-item" href="../ingredients.php">Ingrédients</a>
                </div>
            </li>

        <?php else: ?>

            <li class="nav-item">
                <a class="nav-link" href="../menu"><?= $lang['menu'] ?></a>
            </li>

        <?php endif ?>

        <li class="nav-item">
            <a class="nav-link" href="../location.php"><?= $lang['locations'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../partner.php"><?= $lang['partners'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../event.php"><?= $lang['events'] ?></a>
        </li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                <?= $lang['contact'] ?>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="../contact.php"><?= $lang['contact2'] ?></a>
                <a class="dropdown-item" href="../feedback_form.php"><?= $lang['feedback'] ?></a>
            </div>
        </li>

    </ul>
</nav>

<!-- importing the javascript that will change the transalation session based on the language selected-->
<script src="../../js/jqForAll.js"></script>
<script src="../../js/languagesManagament.js"></script>

<script>

    $(function () {
        let selectSite = $("#siteLanguage");
        checkLanguageSelect(selectSite, "siteLanguage", 1);
        buildLanguageSelectMenu(selectSite, "siteLanguage");
    });

</script>

<?php include_once("socialmedia.php"); ?>

<div id="loginModal" class="modal mt-auto fade">
    <div class="modal-dialog  modal-dialog-centered ">
        <div class="modal-content cf1">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><?= $lang['login_form'] ?></h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <form class="cf1" action="../../controller/user_controller.php" method="post">

                    <input name="email" type="email" id="email" size="30" maxlength="40" required
                           placeholder="<?= $lang['email'] ?>" autofocus/><br/>

                    <input name="password" type="password" id="password" size="30" maxlength="40" required
                           placeholder="<?= $lang['password'] ?>"/><br/>
                    <input name="action" type="hidden" value="login"/>
                    <button type="submit"><?= $lang['connection'] ?></button>
                    <button style="float:left" name="password_forget" value="password_forget" onclick=document.location.href="userPasswordReset.php"><?= $lang['password_forget'] ?></button>

                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="cf1" data-dismiss="modal"><?= $lang['close'] ?></button>
            </div>

        </div>
    </div>
</div>
