<?php
/**
 * Created by PhpStorm.
 * User: Mithul
 * Date: 01/10/2018
 * Time: 20:36
 */

include_once('header.php');


include_once('../model/feedback_model.php');

$listeFeedback = fctFeedbackList();
?>


<br/>
<h3  class = 'pageTitle'><?=$lang['feedback_list']?></h3>
<div class="row">

    <div class="table-responsive" style ="height : 450px;">
        <table class="table">
            <thead>
            <tr>
                <th><?=$lang['feedback_date']?></th>
                <th><?=$lang['feedback_titre']?></th>
                <th><?=$lang['feedback_name']?></th>
                <th><?=$lang['feedback_note']?></th>
                <th><?=$lang['feedback_message']?></th>
                <th><?=$lang['feedback_email']?></th>
                <th><?=$lang['feedback_confirm']?></th>
                <th><?=$lang['feedback_publish']?></th>

            </tr>
            </thead>
            <tbody>


                <?php
                foreach ($listeFeedback as $feedback) {
                    echo "<tr>";
                    echo"<td>". $feedback['DATETIME'] ."</td>";
                    echo"<td>". $feedback['TITLE'] ."</td>";
                    echo"<td>". $feedback['FULL_NAME'] ."</td>";
                    echo"<td>". $feedback['NOTE'] ."</td>";
                    echo"<td>". $feedback['MESSAGE'] ."</td>";
                    echo"<td>". $feedback['EMAIL'] ."</td>";

                    if ($feedback['CONFIRMED'] == 1) {
                        echo "<td>"."Confirmé" . "</td>";
                    } else {
                        echo "<td>"."Non-confirmé". "</td>";
                    }

                    if ($feedback['PUBLISHED'] == 1) {
                        echo "<td>"."Publié" . "</td>";
                    } else {
                        echo "<td>"."Non-publié". "</td>";
                    }
                    ?>
                <?php

                    echo"<td>". "<a href='feedbackDelete.php?id=" . $feedback['FEED_ID'] . "'>Supprimer</a><br/>" ."</td>";

                    echo"<td>". "<a href='feedbackPublish.php?id=" . $feedback['FEED_ID'] . "'>Modifier</a><br/>" ."</td>";
                    echo "</tr>";
                    //echo$feedback['TITLE']." ".$feedback['FULL_NAME'] . " ". $feedback['NOTE'] . " ". $feedback['MESSAGE'] . " ". $feedback['EMAIL'] . " ". $feedback['CONFIRMED']." ".$feedback['PUBLISHED'] . "<td/>"; //<a href='IngredientEdit.php?id=" . $feedback['INGR_ID'] . "'>modifier</a><br/>";
                } ?>

            </tbody>
        </table>
    </div>





</div>
</div>


<?php include_once('footer.php'); ?>
