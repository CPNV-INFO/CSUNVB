<?php
/**
 * Shift.php : all funtion pertaining to database request -> for logs
 * Auteur: Gogniat Michael
 * Date: Février 2021
 **/
ob_start();
$title = "CSU-NVB - Log Remise de garde";
?>

<h2><a href="javascript:history.back()"><i class="fas fa-angle-left backIcon"></i></a>Rapport de garde du : <?=$shiftSheet["date"]?></h2>
<table class="table table-sm table-bordered">
    <thead class="thead-dark">
    <tr>
        <th class="text-center">Date</th>
        <th class="text-center">Initiales</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($logs as $log) : ?>
        <tr>
            <td style="width: 170px;" class="text-center"><?=$log["date"]?></td>
            <td style="width: 90px;" class="text-center"><?=$log["initials"]?></td>
            <td><?=$log["info"]?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
require GABARIT;
?>
