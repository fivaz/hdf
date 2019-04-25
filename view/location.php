<?php
/**
 * Created by PhpStorm.
 * User: MAHESALINGAM_MI-ESIG
 * Date: 10.10.2018
 * Time: 10:09
 */
//if (isset($_SESSION["user"]["PRIVILEGE"])) {
//   echo $_SESSION["user"]["PRIVILEGE"];
//}else{
// echo "non défini.";}

//$_SESSION['user']['privilege'] = 1; //DEBUG ONLY

include_once('header.php');

include_once('../model/location_model.php');
//$listeEmplacements = fctLocationList();


// enable or disable the edit button


$languageId = 1;

if (isset($_COOKIE['siteLanguage'])) {
    $languageId = $_COOKIE['siteLanguage'];
}

$listeEmplacements = fctLocationList(null, $languageId);

?>
<link rel="stylesheet" href="../css/googlemap.css"/>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCq-pVghgZYT9O8E_kolJqusRvdyRQWCHE&sensor=false"></script>

<?php if (!isset($_SESSION['user']['PRIVILEGE']) || $_SESSION['user']['PRIVILEGE'] == 0) { ?>
    <script type="text/javascript" src="../js/googlemap_user.js"></script>
<?php } else if ($_SESSION['user']['PRIVILEGE'] == 1) { ?>
    <script type="text/javascript" src="../js/googlemap_admin.js"></script>
<?php } else {
    echo 'shit happens';
} ?>

<br/>

<h3 style="class = 'pageTitle' text-align :center"><?= $lang['location_list'] ?></h3>

<?


?>

<div style="width: 100%">

    <div style="display:inline-block; float: left; width : 30%;">
        <div class="table-responsive">
            <table class="table">
                <thead>

                </thead>
                <tbody>

                <?php
                foreach ($listeEmplacements as $location) {

                    if (!isset($_SESSION['user']['PRIVILEGE']) || $_SESSION['user']['PRIVILEGE'] == 0) {

                        $modif = "";

                    } else if ($_SESSION['user']['PRIVILEGE'] == 1) {
//                        $modif = "<a href='locationEdit.php?id=" . $location['LOCA_ID'] . "'>modifier</a>";
                        $modif = "
                        
                        <div class=\"dropdown dropright float-right\">
                                       
<i style = type=\"button\" class=\"fa fa-ellipsis-h fa-2x\" data-toggle=\"dropdown\"></i>
            <div class=\"dropdown-menu\">
               
                <a class=\"dropdown-item\"
                        <a href='locationEdit.php?id=" . $location['LOCA_ID'] . "'>modifier</a>    
                                                     
            </div>
            
            
            </div>
                                                                                            
                        ";
                    } else {
                        echo 'shit happens';
                    }


                    echo "<th class ='pageCaption'>" . $location['TITLE'] . $modif . "</th>";
                    echo "<tr>";
                    echo "<td class ='pageCaption'>" . $location['ADDRESS'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td class ='pageCaption'>" . $location['DESCRIPTION'] . "</td>";
                    echo "</tr>";
                    //echo$feedback['TITLE']." ".$feedback['FULL_NAME'] . " ". $feedback['NOTE'] . " ". $feedback['MESSAGE'] . " ". $feedback['EMAIL'] . " ". $feedback['CONFIRMED']." ".$feedback['PUBLISHED'] . "<td/>"; //<a href='IngredientEdit.php?id=" . $feedback['INGR_ID'] . "'>modifier</a><br/>";
                } ?>

                </tbody>
            </table>
        </div>
    </div>
    <div style="display:inline-block; float: left;width:70%;">
        <div id="google_map"></div>

    </div>
    <div style=" clear: both;"></div>
</div>


<?php include_once('footer.php'); ?>
