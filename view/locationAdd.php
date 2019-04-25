<?php
/**
 * Created by PhpStorm.
 * User: Mithul
 * Date: 01/10/2018
 * Time: 20:36
 */

include_once('header.php');

?>
<div class="row">

    <div class="container center col-5">

        <div class="fform">

            <h3>Ajouter un emplacement</h3>
            <form class="cf1" method="post" action="../controller/location_controller.php">
                <input type="text" name="locationTitle" size=50 placeholder="Titre de l'emplacement" required
                       autofocus/><br/>
                <input type="text" name="locationAddress" size=50 placeholder="Adresse de l'emplacement" required/><br/>
                <textarea name="locationDescription" placeholder="Description de l'emplacement"></textarea><br/>
                <input type="hidden" name="action" value="locationAdd"/>
                <button type="submit" value="Ajouter">Ajouter</button>
            </form>
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>
