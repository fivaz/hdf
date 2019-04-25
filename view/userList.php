<?php
/**
 * Created by PhpStorm.
 * User: CABRERA_DANIEL-ESIG
 * Date: 25.09.2018
 * Time: 09:13
 */




include_once('header.php');

include_once("../model/user_model.php");
// $admin=$_SESSION['PRIVILEGE']==0;



if (!isset($_COOKIE['privilegeFilter'])){
    $userList = filterUser(0);
}else{
    $userList = filterUser($_COOKIE['privilegeFilter']);
}


//$userList = fctUserList();

?>
<div class="row">

    <div class="container center col-5">

        <div class="fform cf1">


            <!--            <form action="userList.php" name="formUtilisateurs"  method="post">-->
            <!--                <select  name="select">-->
            <!--                    <option value="userList.php?utilisateurs=1">Administrateurs</option>-->
            <!--                    <option value="userList.php?utilisateurs=0">Clients</option>-->
            <!--                </select>-->

            <!--               --><?php
            ////                if (isset($_GET['utilisateurs'])) {
            ////                    if ($_GET['utilisateurs'] == "1") {
            ////                    echo"<h1>Liste des Administrateurs</h1>";
            ////                    } elseif ($_GET['utilisateurs'] == "0") {
            ////                           echo"<h1>Liste des Clients</h1>";
            ////                    }
            ////                }
            ////                ?>
<!--            --><?php //$_POST['view'];?>

            <select id="privilegeSelect" name="page">

                <option name="view" value="1"><?= $lang['admin'] ?></option>

                <?php if(isset($_COOKIE['privilegeFilter']) && $_COOKIE['privilegeFilter'] == 1): ?>

                    <option name="view" value="0"><?= $lang['customer'] ?></option>


                <?php else: ?>

                    <option name="view" value="0" selected><?= $lang['customer'] ?></option>

                <?php endif ?>

            </select>
            <p id="privilegeSelect" >
            <?php if(isset($_COOKIE['privilegeFilter']) && $_COOKIE['privilegeFilter'] == 1): ?>

                <h1><?= $lang['admin_list'] ?></h1>


                <?php else: ?>

                 <h1><?= $lang['client_list'] ?></h1>



            <?php endif?>
            <p/>



<!--                    //content for page 2-->
            <table class=" table table-striped table-hover table-striped table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th><?= $lang['lastname'] ?>
                    </th>
                    <th><?= $lang['firstname'] ?>
                    </th>
                    <th><?= $lang['email'] ?>
                    </th>
                </tr>
                </thead>

                <tbody>

                <?php foreach ($userList as $user): ?>

                    <tr>
                        <td><?= $user['LAST_NAME'] ?></td>

                        <td><?= $user['FIRST_NAME'] ?> </td>

                        <td><?= $user['EMAIL'] ?></td>
                        <td>
                            <div class="dropdown" style="display:inline">

                                <i  class="fa fa-ellipsis-h fa-2x" data-toggle="dropdown"></i>

                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="userEdit.php?id=<?= $user['USER_ID'] ?>"><?= $lang['edit'] ?></a>
                                    <?php if($_SESSION['user']['USER_ID']== $user['USER_ID']){?>
                                        <i class="dropdown-item text-black-50"  ><?= $lang['disable'] ?></i>
                                        <?php }elseif ($user['ISACTIVE']==1){?>

                                         <a class="dropdown-item" href="userChangeActive.php?user=<?= $user['USER_ID']?>&active=0" ><?= $lang['disable'] ?></a>

                                    <?php }elseif ($user['ISACTIVE']==0){?>

                                         <a class="dropdown-item" href="userChangeActive.php?user=<?= $user['USER_ID']?>&active=1"><?= $lang['enable'] ?></a>

                                    <?php } ?>

                                </div>
                            </div>

                        </td>
                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>
    </div>
</div>

<script src="user/userFilterManagament.js"></script>

<script>

    $(function()
    {
        let select = $("#privilegeSelect");
        checkUserSelect(select, "privilegeFilter");
    });

    $(function()
    {
        let select = $("#privilegeSelect");
        checkUserSelect(select, "privilegeFilter");
    });

</script>

<?php include_once('footer.php'); ?>

