<?php
ob_start();
$title = "CSU-NVB - Tâches hebdomadaires";
?>
<input type="hidden" id="sheetID" value="<?= $week['id'] ?>"><!-- used to get date in javascrpt -->
<a href="javascript:history.back()" class="text-dark d-print-none"><i class="fas fa-angle-left backIcon"></i>Retour</a>
<h1>
    Tâches hebdomadaires
</h1>
<div class="float-right d-print-none d-inline">
    <?= slugBtns("todo", $week, $week['slug']) ?>
    <?= (!$edition && ican("modifySheet") && $week['slug'] == "blank") ? '<form method="POST" class="d-inline" action="?action=todoEditionMode&id=' . $week['id'] . '"><button type="submit" class="btn blueBtn m-0"><i class="fa fa-pen"></i></button></form>' : '' ?>
    <button class="btn blueBtn d-inline m-1" onclick="print_page()"><i class="fas fa-file-pdf fa-lg"></i></button>
    <form method="POST" style="display: inline" action="?action=todoLog&id=<?= $week['id']?>"><button type="submit" class="btn blueBtn d-inline m-1"><i class="fas fa-history fa-lg"></i></button></form>
</div>
<h5>
    Semaine <?= $week['week'] ?><br>
    Base : <?= $base['name'] ?><br>
    Status : <?= $week['displayname'] ?> <?= ($week['slug'] == 'close') ? ' par ' . $week['closeBy'] : '' ?>
</h5>
<?php if (ican("modifySheet") && $edition) : ?> <!-- Zone d'ajout de nouvelle tâche -->
    <div class="d-print-none container editSheetForm inactivForm" id="editSheetForm">
        <a href="?action=showtodo&id=<?= $week['id'] ?>"><i
                    class='fas fa-times fa-lg text-dark float-right d-inline'></i></a>
        <h5>Mode d'édition</h5>
        <table>
            <tr>
                <td>
                    Jour de la semaine
                </td>
                <td>
                    <select name="day" id="selectDay" class="marginLeft smallInput">
                        <option value="" selected disabled hidden></option>
                        <?php foreach ($dates as $index => $date) : ?>
                            <option name="day" value="<?= $index + 1 ?>"><?= $days[$index + 1] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td class="maskIfInactiv">
                    <div class="marginLeft">
                        Tâche :
                    </div>
                </td>
                <td class="maskIfInactiv">
                    <select id="missingTask" class="bigInput">
                    </select>
                </td>
                <td class="maskIfInactiv">
                    <button class="addBtn btn-dark" id="addOldTask"><i class="fas fa-plus"></i></button>
                </td>
            </tr>
            <tr>
                <td class="marginTop">
                    Créneau
                </td>
                <td class="float-left">
                    <select name="dayTime" id="selectTime" class="float-right marginLeft marginTop smallInput">
                        <option value="" selected disabled hidden></option>
                        <option name="dayTime" value="1">Jour</option>
                        <option name="dayTime" value="0">Nuit</option>
                    </select>
                </td>
                <td colspan="2" class="maskIfInactiv">
                    <input type="text" class='float-right marginTop bigInput' id="newTask">
                </td>
                <td class="maskIfInactiv">
                    <button class="addBtn btn-dark marginTop" id="addNewTask"><i class="fas fa-plus"></i></button>
                </td>
            </tr>
        </table>
    </div>
<?php endif; ?>
<div class="week text-center p-0" style="margin-top: 15px;overflow-x: scroll"> <!-- Affichage des tâches -->
    <table style="width: 100%" class="todoTable flex">
        <thead>
        <tr class="flex">
            <?php foreach ($dates as $index => $date) : ?>
                <th>
                    <div class='bg-dark text-white col-md font-weight-bold flex-grow-1'
                         id="day-<?= $index + 1 ?>"><?= $days[$index + 1] ?>
                        <br><?= displayDate($date, 0) ?>
                </th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="7">
                <div class="week text-center bg-dark" style="margin-top: 5px;">
                    <div class="col-md font-weight-bold text-white">Jour</div>
                </div>
            </td>
        </tr>
        <tr value="Jour">
            <?php foreach ($dates as $index => $date) : ?>
                <td style="vertical-align: top;" class="taskCol" value=<?= $index + 1 ?>>
                    <?php foreach ($todoThings[1][$index + 1] as $todothing): ?>
                        <?= buttonTask($todothing['initials'], $todothing['id'], $todothing['description'], $state, $todothing['type']) ?>
                    <?php endforeach; ?>
                </td>
            <?php endforeach; ?>
        </tr>
        <tr>
            <td colspan="7">
                <div class="week text-center bg-dark" style="margin-top: 40px;">
                    <div class="col-md font-weight-bold  text-white">Nuit</div>
                </div>
            </td>
        </tr>
        <tr value="Nuit">
            <?php foreach ($dates as $index => $date) : ?>
                <td style="vertical-align: top;" class="taskCol" value=<?= $index + 1 ?>>
                    <?php foreach ($todoThings[0][$index + 1] as $todothing): ?>
                        <?= buttonTask($todothing['initials'], $todothing['id'], $todothing['description'], $state, $todothing['type']) ?>
                    <?php endforeach; ?>
                </td>
            <?php endforeach; ?>
        </tr>
        </tbody>
    </table>
</div>
<div class="d-flex flex-row d-print-none"> <!-- Boutons relatifs aux modèles -->
    <?php if (ican("createTemplate") && is_null($template['template_name'])) : ?>
        <form action="?action=modelWeek" method="POST">
            <button type="submit" class='btn blueBtn m-1'>Retenir comme modèle</button>
            <input type="hidden" name="todosheetID" value="<?= $week['id'] ?>">
            <input type="hidden" name="baseID" value="<?= $base['id'] ?>">
            <input type="text" name="template_name" value="" placeholder="Nom du modèle" required>
        </form>
    <?php elseif (ican("deleteTemplate") && !is_null($template['template_name'])): ?>
        <form action="?action=deleteTemplate" method="POST">
            <input type="hidden" name="todosheetID" value="<?= $week['id'] ?>">
            <button type="submit" class='btn blueBtn m-1'>Oublier le modèle</button>
        </form>
        <div style="padding: 5px"> Nom du modèle : <?= $template['template_name'] ?></div>
    <?php endif; ?>
</div>
</div>
<script src="js/todo.js"></script>
<?php
$content = ob_get_clean();
require GABARIT;
?>

