<?php
/**
 * Title: CSUNVB
 * USER: michael gogniat
 * DATE: 22.03.2021
 **/
ob_start();
$title = "CSU-NVB - Accueil";
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h3>Tâches</h3>
            <?php foreach ($todoSheets as $todoSheet): ?>
                <div class="slugOpen dashboardElem" onclick="location.href='?action=showtodo&id=<?= $todoSheet["id"] ?>';">
                    Semaine : <?= $todoSheet["week"] ?>
                </div>
            <?php endforeach; ?>
            <h3>Stupéfiants</h3>
            <?php foreach ($stupSheets as $stupSheet): ?>
                <div class="slugOpen dashboardElem" onclick="location.href='?action=showDrugSheet&id=<?= $stupSheet["id"] ?>';">
                    Semaine : <?= $stupSheet["week"] ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col">
            <h3>Gardes</h3>
            <?php foreach ($openShifts as $openShift): ?>
                <div class="slugOpen dashboardElem" onclick="location.href='?action=shiftShow&id=<?= $openShift["id"] ?>';">
                    <?= date('d.m.Y', strtotime($openShift["date"])) ?>
                    <br>Rôle :
                    <?php foreach ($openShift["roles"] as $role): ?>
                        <?= $role["name"] ?>
                    <?php endforeach; ?>
                    <br>Tâches effectuées : <?= $openShift["nbDone"] ?> / <?= $openShift["nbTasks"] ?>
                    <br>Status : Actif
                </div>
            <?php endforeach; ?>
            <?php foreach ($blankShifts as $blankShift): ?>
                <div class="slugBlank dashboardElem" onclick="location.href='?action=shiftShow&id=<?= $blankShift["id"] ?>';">
                    <?= date('d.m.Y', strtotime($blankShift["date"]))?>
                    <br>Rôle :
                    <?php foreach ($blankShift["roles"] as $role): ?>
                        <?= $role["name"] ?>
                    <?php endforeach; ?>
                    <br>Status : En Préparation
                </div>
            <?php endforeach; ?>
            <?php foreach ($reOpenShifts as $reOpenShift): ?>
                <div class="slugReopen dashboardElem" onclick="location.href='?action=shiftShow&id=<?= $reOpenShift["id"] ?>';">
                    <?= date('d.m.Y', strtotime($reOpenShift["date"])) ?>
                    <br>Rôle :
                    <?php foreach ($reOpenShift["roles"] as $role): ?>
                        <?= $role["name"] ?>
                    <?php endforeach; ?>
                    <br>Status : En Correction
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require GABARIT;
?>
