<?php
/** ----------------------------------------PAS UTILISE
 * Created by PhpStorm.
 * User: Frank
 * Date: 01/10/2018
 * Time: 20:36
 */

include_once('../model/foodintolerance_model.php');
?>
<meta charset="UTF-8">
<h1>Ajouter une intolérance</h1>
<form method="post" action="../controller/intolerance_controller.php">
    <input type="text" name="intoleranceName" size=50 placeholder="Nom de l'intolérance" required autofocus/><br/>
    <input type="submit" value="Ajouter"/>
</form>


