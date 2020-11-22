<!--
COMMENTAIRES
-->
<?php

function homeWeeklyTasks($selectedBase){
    $weeksNbrList = weeksNbrForClosed($selectedBase); // La liste des numéros de semaines qui sont fermées
    $activeWeekNbr = weeksNbrForOpen($selectedBase);  // Le numero de la semaine active

    $baseList = getBasesName();
    require_once VIEW . 'todo/homeWeeklyTasks.php';
}