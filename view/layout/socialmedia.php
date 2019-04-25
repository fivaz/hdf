<?php
/**
 * Socialmedia links sidebar box
 * User: Frank Théodoloz
 * Date: 28.09.2018
 * Time: 16:55
 */

include_once("../../model/parameter_model.php");
?>

<div class="socialmedia-sidebar boxed d-md-block d-none">
    <a href="http://<?= fctParameterGet("LINK_INSTAGRAM")[0] ?>">
        <i class="fab fa-instagram fa-2x" aria-hidden="true" style="color:white"></i>
    </a>
    <a href="http://<?= fctParameterGet("LINK_FACEBOOK")[0] ?>">
        <i class="fab fa-facebook-square fa-2x" aria-hidden="true" style="color:white"></i>
    </a>
    <a href="http://<?= fctParameterGet("LINK_TWITTER")[0] ?>">
        <i class="fab fa-twitter fa-2x" aria-hidden="true" style="color:white"></i>
    </a>
    <a href="http://<?= fctParameterGet("LINK_TRIPADVISOR")[0] ?>">
        <i class="fab fa-tripadvisor fa-2x" aria-hidden="true" style="color:white"></i>
    </a>
</div>
