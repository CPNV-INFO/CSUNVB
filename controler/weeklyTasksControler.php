<!--
COMMENTAIRES
-->
<?php
/** Fonction qui permet l'affichage des semaines de tâches pour une base donnée
 * @param $selectedBaseID : la base dont les semaines sont à afficher id
 */
function homeWeeklyTasks($selectedBaseID){
    $weeksNbrList = weeksNbrForClosed($selectedBaseID); // La liste des numéros de semaines qui sont fermées
    $activeWeekNbr = weeksNbrForOpen($selectedBaseID);  // Le numero de la semaine active

    $baseList = getBasesName();
    require_once VIEW . 'todo/homeWeeklyTasks.php';
}

function showWeeklyTasks($weekNbr){
    $dates = getDatesFromWeekNumber($weekNbr);
    // Récupération des dates par rapport à la semaine
    require_once VIEW . 'todo/detailsWeeklyTasks.php';
}

