<!--
 * Projet   : CSUNVB
 * Fichier  : homeToDo.php
 * Auteur   : Vicky BUTTY
 * Version  : 2.0
 * Description: Permet l'affichage sous forme de liste des différents rapports hebdomadaires.
 * Page basée, en partie, sur le travail précédement réalisé par Marwan ALHELO [13.02.2020] & Gatien JAYME [27.08.2020]
-->
<?php
ob_start();
$title = "CSU-NVB - Tâches hebdomadaires";
?>
<div>
    <form><!-- Liste déroulante pour le choix de la base -->
        <input type="hidden" name="action" value="listtodoforbase">
        <div class="row">
            <h1 class="mr-3">Tâches hebdomadaires à </h1>
            <select onchange="this.form.submit()" name="id" size="1" class="bigfont mb-3">
                <?php foreach ($baseList as $base) : ?>
                    <option value="<?= $base['id'] ?>" <?= ($baseID == $base['id']) ? 'selected' : '' ?>
                            name="base"><?= $base['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
    <div class="sheetForm newSheet"><!-- Liste déroulante pour le choix du modèle et bouton de nouvelle semaine -->
        <?php if (ican('createsheet') && ($_SESSION['base']['id'] == $baseID)) : ?>
            <form method=" POST" action="?action=addWeek">
                Modèle :
                <select name="selectModel" id="selectTodoModel" class="choseModel">
                    <?php if (isset($lastClosedWeek['id'])): ?>
                        <option value='lastValue' selected=selected>Dernier rapport clôturé</option>
                    <?php endif; ?>
                    <?php foreach ($templates as $template) : ?>
                        <option value='<?= $template['template_name'] ?>'><?= $template['template_name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn blueBtn m-1" id="newTodoBtn" disabled>Nouveau Rapport</i></button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?= listSheet("todo", $sheets)?>
<script src="js/todo.js"></script>
<?php
$content = ob_get_clean();
require GABARIT;
?>
