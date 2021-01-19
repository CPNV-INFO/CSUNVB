<?php
/**
 * Auteur: David Roulet / Fabien Masson
 * Date: Aril 2020
 **/

$title = "CSU-NVB - Stupéfiants";
ob_start();
?>
<script src="js/drugs.js"></script>
<div>
    <h1>Stupéfiants</h1>
    <h2>Semaine <?= $drugsheet["week"] ?> - Base de <?= $site['name'] ?> [<?= $drugsheet['displayname'] ?>]</h2>
    <div class="d-flex justify-content-end d-print-none">
        <button type='submit' class='btn btn-primary m-1 float-right' onclick="window.print()">Télécharger en PDF
        </button>
        <form>
            <input type="hidden" name="action" value="listDrugSheets">
            <input type="hidden" name="id" value="<?= $site['id'] ?>">
            <button type="submit" class='btn btn-primary m-1 float-right'>Retour à la liste</button>
        </form>
    </div>
</div>
<div class="float-right d-print-none">
    <?= slugButtons("todo", $drugsheet, $drugsheet['slug']) ?>
</div>

<?php foreach ($dates as $date): ?>
    <table border="1" class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th colspan="6" <?= ($date == date("Y-m-d")) ? "class='today'" : "" ?>>
                <?= displayDate($date, 1) ?>
            </th>
        </tr>
        <tr>
            <th>
                <?php //TODO: th a supprimer? ?>
            </th>
            <th>Pharmacie (matin)</th>
            <?php foreach ($novas as $nova): ?>
                <th><?= $nova["number"] ?></th>
            <?php endforeach; ?>
            <th>Pharmacie (soir)</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($drugs as $drug): ?>
            <tr>
                <td class="font-weight-bold"><?= $drug["name"] ?></td>
                <td></td>
                <?php foreach ($novas as $nova): ?>
                    <?php $ncheck = getNovaCheckByDateAndDrug($date, $drug['id'], $nova['id'], $drugsheet['id']); // not great practice, but it spares repeated queries on the db ?>
                    <?php $UID = $nova["number"] . $drug["name"] . $date ?>
                    <td id="<?= $UID ?>">
                        <input type="number" min="0" width="30" height="100" class="text-center"
                               value="<?= $ncheck ? $ncheck["start"] : '' ?>"
                               onchange="cellUpdate(<?= "'" . $UID . "'" ?>);"
                               id="<?= $UID ?>start">
                        <input type="number" min="0" width="20" height="30" class="text-center"
                               value="<?= $ncheck ? $ncheck["end"] : '' ?>"
                               onchange="cellUpdate(<?= "'" . $UID . "'" ?>);"
                               id="<?= $UID ?>end">
                    </td>
                <?php endforeach; ?>
                <td></td>
            </tr>
                <?php foreach ($batchesByDrugId[$drug["id"]] as $batch): ?>
                    <?php $UID = "pharma" . $drug["name"] . $date ?>
                    <?php $pcheck = getPharmaCheckByDateAndBatch($date, $batch['id'], $drugsheet['id']); // not great practice, but  it spares repeated queries on the db ?>
                    <tr>
                        <td class="text-right"><?= $batch['number'] ?></td>
                        <td class="text-center">
                            <input id="<?= $UID ?>start" type="number" min="0"
                                   value="<?= $pcheck ? $pcheck['start'] : '' ?>"
                                   onchange="cellUpdate(<?= "'" . $UID . "'" ?>);">
                        </td>
                        <?php foreach ($novas as $nova): ?>
                            <td class="text-center">
                                <input class="<?= $UID ?> nova" type="number" min="0"
                                       value="<?= getRestockByDateAndDrug($date, $batch['id'], $nova['id']) ?>"
                                       onchange="cellUpdate(<?= "'" . $UID . "'" ?>);">
                            </td>
                        <?php endforeach; ?>
                        <td id="<?= $UID ?>" class="text-center">
                            <input id="<?= $UID ?>end" type="number" min="0"
                                   value="<?= $pcheck ? $pcheck['end'] : '' ?>"
                                   onchange="cellUpdate(<?= "'" . $UID . "'" ?>);">
                        </td>
                    </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <tr>
            <td>Signature</td>
            <td colspan="5"></td>
        </tr>
        </tbody>
    </table>
<?php endforeach; ?>

<?php
$content = ob_get_clean();
require GABARIT;
?>
