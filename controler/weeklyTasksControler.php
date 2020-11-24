<!--
COMMENTAIRES
-->
<?php
/** Fonction qui permet l'affichage des semaines de tâches pour une base donnée
 * @param $selectedBase : la base dont les semaines sont à afficher
 */
function homeWeeklyTasks($selectedBase){
    $weeksNbrList = weeksNbrForClosed($selectedBase); // La liste des numéros de semaines qui sont fermées
    $activeWeekNbr = weeksNbrForOpen($selectedBase);  // Le numero de la semaine active

    $baseList = getBasesName();
    require_once VIEW . 'todo/homeWeeklyTasks.php';
}

function showWeeklyTasks($weekNbr){
    $dates = getDatesFromWeekNumber($weekNbr);
    // Récupération des dates par rapport à la semaine
    require_once VIEW . 'todo/detailsWeeklyTasks.php';
}

