<?php
/**
 * Created by PhpStorm.
 * User: Frank Théodoloz
 * Date: 24/09/2018
 * Time: 13:40
 */

include_once('../model/feedback_model.php');
$listeAvis = fctFeedbackList();
include_once("header.php");

?>
<div class="container mt-5">
    <div class="row">
        <div class="col">

            <div class="d-flex ">

                <div class="boxed ml-5 col-4 align-self-start flex-fill">

                    <div class="boxTitle1"><h3>EVENEMENT</h3></div>
                    <div class="text"><h4>The Restaurant THDF est ouvert à Genève (rue Rousseau 14) !</h4></div>

                    <div class="boxTitle2"><h3>NEWS !!!</h3></div>
                    <div class="text"><h4>MENU ETUDIANT<br/>CHF 9,90.-</h4></div>

                    <div class="boxTitle2"><h3>RETROUVEZ-NOUS !!!</h3></div>
                    <div id="demo" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active text-center p-4">
                                Demo Event1<br/>carousel
                                <!--                    <img src="la.jpg" alt="Los Angeles">-->
                            </div>
                            <div class="carousel-item text-center p-4">
                                Demo Event2<br/>carousel
                                <!--                    <img src="la.jpg" alt="Los Angeles">-->
                            </div>
                        </div>
                    </div>

                    <div class="boxTitle2"><h3>VOS AVIS</h3></div>
                    <div id="demo" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class='carousel-item active text-center p-4'>
                                Donnez-votre avis<br/><a href="feedback_form.php">Cliquez-ici</a>
                                <!--                    <img src="la.jpg" alt="Los Angeles">-->
                            </div>

                            <?php foreach ($listeAvis as $avis) {
                                if ($avis['PUBLISHED'] == 1) {
                                    echo "<div class='carousel-item text-center p-4'/>";
                                    echo "Note : " . $avis['NOTE'] . "<br/>";
                                    echo $avis['MESSAGE'] . "<br/>";
                                    echo $avis['FULL_NAME'] . "<br/>";
                                    echo "</div>";
                                }
                            }
                            ?>

                        </div>
                    </div>

                </div>

                <div class=" mx-lg-5 mx-md-3 mx-sm-2 col-4 align-self-start flex-fill">
                    <div class="img-box boxed">
                        <img src="../resources/love.png">
                    </div>

                    <div class="mt-3 boxed2">
                        <div>
                            <h1>Près</h1>
                            <h1 class="yellow">de chez vous !</h1>
                        </div>
                        <div>
                            <h6>Tout au long de l'année et lors des grands événements, nous sommes à vos côtés !</h6>
                            <h6 class="yellow">Fribourg - Vaud - Valais - Genève - et plus encore...</h6>
                            <button class="cf1 btn">Nous trouver</button>
                        </div>
                    </div>
                </div>
                <div class="img-box boxed mr-5 col-4 align-self-start flex-fill">
                    <img src="../resources/fake_Instagram.png">
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $('body').css('background-image', 'url("../resources/background_city.jpg")');
</script>
<?php include_once('footer.php') ?>



