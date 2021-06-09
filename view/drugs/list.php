<?php
ob_start();
$title = "CSU-NVB - Drogues hebdomadaires";
?>
<div class="row">
    <form><!-- Liste déroulante pour le choix de la base -->
        <input type="hidden" name="action" value="listDrugSheets">
        <h1 class="ml-3 mr-3 d-inline">Site </h1>
        <select onchange="this.form.submit()" name="id" size="1" class="bigfont mb-3">
            <?php foreach ($baseList as $base) : ?>
                <option value="<?= $base['id'] ?>" <?= ($selectedBaseID == $base['id']) ? 'selected' : '' ?>
                        name="base"><?= $base['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </form>
    <div class="buttonsZone"> <!-- Bouton de nouvelle semaine -->
        <?php if (ican('createsheet') && ($_SESSION['base']['id'] == $selectedBaseID)) : ?>
            <form method="POST" action="?action=newDrugSheet" style="margin-block-end: 0;" class="float-right">
                <button type="submit" class="btn blueBtn ml-5 mt-1">Nouvelle semaine</button>
            </form>
        <?php endif; ?>
        <?php if (ican('openBatchList') && ($_SESSION['base']['id'] == $selectedBaseID)) : ?>
            <form method="POST" action="?action=showBatchList" style="margin-block-end: 0;" class="float-right">
                <button type="submit" class="btn blueBtn ml-5 mt-1">Lots de médicaments</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<?= listSheet('drug', $drugSheetList) ?>

<?php
$content = ob_get_clean();
require GABARIT;
?>
