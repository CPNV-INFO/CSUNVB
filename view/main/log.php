<?php
/**
 * Shift.php : all funtion pertaining to database request -> for logs
 * Auteur: Gogniat Michael
 * Date: Février 2021
 **/
ob_start();
switch ($type) {
    case "SHIFT":
        $title = "CSU-NVB - Log Remise de garde";
        $shiftName = "Log : Rapport de garde du : ".$sheet["date"];
        break;
    case "TODO":
        $title = "CSU-NVB - Log Tâches Hebdomadaires";
        $shiftName = "Log : Tâches Hebdomadaires : Semaine ". $sheet["week"];
        break;
    default:
        $title = "CSU-NVB - Logs inderterminés";
        $shiftName = "Logs inderterminés";
        break;
}
?>

<h2><a href="javascript:history.back()"><i class="fas fa-angle-left backIcon"></i></a><?= $shiftName ?></h2>
<table class="table table-sm">
    <tbody>
    <?php foreach ($logs as $log) : ?>
        <tr>
            <td>[ <?= $log["initials"] ?> - <?= date('H:i / d.m.Y', strtotime($log["date"])) ?> ] : <?= $log["info"] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
require GABARIT;
?>
