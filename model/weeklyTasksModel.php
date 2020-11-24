<?php
/**
 * Function that allow to find the numbers of all the week's tasklists closed for a specific base.
 * @param $base
 * @return array|mixed|null
 */
function weeksNbrForClosed($base)
{
    $query = "SELECT t.week FROM todosheets t JOIN bases b ON t.base_id = b.id WHERE b.name = '$base' AND t.state = 'close' ORDER BY t.week DESC;";
    return selectMany($query, []);
}

/**
 * Function that allow to find the numbers of the week's tasklist open for a specific base.
 * @param $base
 * @return int
 */
function weeksNbrForOpen($base)
{
    $query = "SELECT t.week FROM todosheets t JOIN bases b ON t.base_id = b.id WHERE b.name = '$base' AND t.state = 'open';";
    return selectOne($query, []);
}

function getBasesName(){
    $query = "SELECT b.name FROM bases b;";
    return selectMany($query, []);
}

function getDatesFromWeekNumber($weekNumber){
    $year = 2000 + intdiv($weekNumber,100);
    $week = $weekNumber%100;

    $dates = Array();
    //setlocale(LC_TIME, 'fr'); <- Vérification que cette ligne ne posera aucun problème !
    $time = strtotime(sprintf("%4dW%02d", $year, $week));

    for($i = 0; $i < 7; $i++){
        $day = date(strtotime("+".$i." day", $time));
        $fullDate = strftime('%A %e %b %Y', $day);
        $dates[] = $fullDate;
    }

    return $dates;
}
?>