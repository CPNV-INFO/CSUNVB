<?php
ob_start();
$title = "CSU-NVB - Tâches hebdomadaires";
?>
<div>
    <h1 id="test">Tâches hebdomadaires</h1>
    <h2>Semaine <?= $week['week'] ?> - Base de <?= $base['name'] ?> [<?= $week['displayname'] ?>] <?= ($week['slug'] == 'close') ? ' par ' . $week['closeBy'] : $week['closeBy'] ?></h2>
    <input type="hidden" id="sheetID" value="<?= $week['id'] ?>"><!-- used to get date in javascrpt -->
    <div class="d-flex justify-content-end d-print-none">

        <button type='submit' class='btn btn-primary m-1 float-right'
                onclick="window.print()" <?= !$edition ? '' : 'disabled' ?> >Télécharger en PDF
        </button>
        <form>
            <input type="hidden" name="action" value="listtodoforbase">
            <input type="hidden" name="id" value="<?= $base['id'] ?>">
            <button type="submit" class='btn btn-primary m-1 float-right'>Retour à la liste</button>
        </form>
    </div>
</div>
<div class="d-flex justify-content-between d-print-none">
    <div class="d-flex flex-row"> <!-- Boutons relatifs aux modèles -->
        <?php if (ican("createTemplate") && is_null($template['template_name'])) : ?>
            <form action="?action=modelWeek" method="POST">
                <button type="submit" class='btn btn-primary m-1'>Retenir comme modèle</button>
                <input type="hidden" name="todosheetID" value="<?= $week['id'] ?>">
                <input type="hidden" name="baseID" value="<?= $base['id'] ?>">
                <input type="text" name="template_name" value="" placeholder="Nom du modèle" required>
            </form>
        <?php elseif (ican("deleteTemplate") && !is_null($template['template_name'])): ?>
            <form action="?action=deleteTemplate" method="POST">
                <input type="hidden" name="todosheetID" value="<?= $week['id'] ?>">
                <button type="submit" class='btn btn-primary m-1'>Oublier le modèle</button>
            </form>
            <div style="padding: 5px"> Nom du modèle : <?= $template['template_name'] ?></div>
        <?php endif; ?>
    </div>
    <div class="d-flex flex-row"> <!-- If user is admin and sheet is "blank" then show modification button -->
        <?php if (ican("modifySheet") && $week['slug'] == "blank") : ?>
            <?php if ($edition) :
                $text = "Quitter édition";
            else:
                $text = "Mode édition";
            endif; ?>
            <form action="?action=todoEditionMode" method="POST">
                <input type="hidden" name="todosheetID" value="<?= $week['id'] ?>">
                <input type="hidden" name="edition" value="<?= $edition ?>">
                <button type="submit" class='btn btn-warning m-1 float-right'><?= $text ?></button>
            </form>
        <?php endif; ?>
        <?= slugBtns("todo", $week, $week['slug']) ?>
    </div>
</div>

<?php if (ican("modifySheet") && $edition) : ?> <!-- Zone d'ajout de nouvelle tâche -->
    <div class="d-print-none" style="border: solid; padding: 5px; margin: 2px; margin-top: 15px; margin-bottom: 15px">
        <form method="POST" action="?action=addTodoTask" class="d-flex justify-content-between">
            <div class="d-flex">
                <div>
                    <label for="missingTaskDay" style="padding: 0 15px">Jour de la semaine </label>
                    <select name="day" id="missingTaskDay" class='missingTasksChoice' style="width: 100px;">
                        <option value="default"></option>
                        <?php foreach ($dates as $index => $date) : ?>
                            <option name="day" value="<?= $index + 1 ?>"><?= $days[$index + 1] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="missingTaskTime" style="padding: 0 15px">Créneau </label>
                    <select name="dayTime" id="missingTaskTime" style="width: 100px;"
                            class="missingTasksChoice float-right">
                        <option value="default"></option>
                        <option name="dayTime" value="1">Jour</option>
                        <option name="dayTime" value="0">Nuit</option>
                    </select>
                </div>

                <div style="padding: 20px 20px 0;">
                    <?= dropdownTodoMissingTask($missingTasks) ?>
                </div>
            </div>
            <input type="hidden" name="todosheetID" value="<?= $week['id'] ?>">
            <button type="submit" id="addTodoTaskBtn" class='btn btn-primary m-1' disabled>Ajouter la tâche</button>
        </form>
    </div>
<?php endif; ?>
<div class="week text-center p-0"  style="margin-top: 15px;overflow-x: scroll"> <!-- Affichage des tâches -->
    <table style="width: 100%" class="todoTable">
        <thead>
        <tr>
            <?php foreach ($dates as $index => $date) : ?>
                <th>
                    <div class='bg-dark text-white col-md font-weight-bold' id="day-<?=$index+1?>"><?= $days[$index + 1] ?>
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
                <td style="vertical-align: top;" class="taskCol" value=<?=$index+1?>>
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
                <td style="vertical-align: top;" class="taskCol" value=<?=$index+1?>>
                    <?php foreach ($todoThings[0][$index + 1] as $todothing): ?>
                        <?= buttonTask($todothing['initials'], $todothing['id'], $todothing['description'], $state,$todothing['type']) ?>
                    <?php endforeach; ?>
                </td>
            <?php endforeach; ?>
        </tr>
        </tbody>
    </table>
    </div>
</div>
<script src="js/todo.js"></script>
<?php
$content = ob_get_clean();
require GABARIT;
?>

