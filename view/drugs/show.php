<?php
/**
 * Auteur: David Roulet / Fabien Masson
 * Date: Aril 2020
 **/

$title = "CSU-NVB - Stupéfiants";
ob_start();
?>
<script src="js/drugs.js"></script>
<div class="row m-2">
    <h1>Stupéfiants</h1>
</div>
<h2>Site de <?= $site ?>, Semaine N°<?= $drugsheet["week"] ?></h2>
<?php //TODO: a simplifier ?>
<a href='?action=<?= $buttonState ?>DrugSheet&id=<?= $drugsheet["base_id"] ?>&week=<?= $drugsheet["week"]?>'>
    <button class='btn btn-primary btn-sm ml-3'><?= $buttonState ?></button>
</a>
<?php foreach ($dates as $date): ?>
    <table border="1" class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th colspan="6" <?= ($date == date("Y-m-d")) ? "class='today'" : "" ?>>
                    <?= displayDate($date,1) ?>
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
                        <td id="<?= $nova["number"] . $drug["name"] . $date ?>">
                            <input type="number" min="0" width="30" height="100" class="text-center" value="<?= $ncheck ? $ncheck["start"] : ''?>" onchange="novaCheck(<?= "'" . $nova["number"] . "', '" . $drug["name"] . "', '" . $date . "'" ?>);" id="<?= $nova["number"] . $drug["name"] . $date ?>start">
                            <input type="number" min="0" width="20" height="30" class="text-center" value="<?= $ncheck ? $ncheck["end"] : '' ?>" onchange="novaCheck(<?= "'" . $nova["number"] . "', '" . $drug["name"] . "', '" . $date . "'" ?>);" id="<?= $nova["number"] . $drug["name"] . $date ?>end">
                        </td>
                    <?php endforeach; ?>
                    <td></td>
                </tr>
                <?php foreach ($batchesByDrugId[$drug["id"]] as $batch): ?>
                    <?php $pcheck = getPharmaCheckByDateAndBatch($date, $batch['id'], $drugsheet['id']); // not great practice, but  it spares repeated queries on the db ?>
                    <tr>
                        <td class="text-right"><?= $batch['number'] ?></td>
                        <td class="text-center">
                            <input id='<?= $drug["name"] . $date . "start"?>' type="number" min="0" width="30" height="100" class="text-center" value="<?= $pcheck ? $pcheck['start'] : '' ?>" onchange="pharmaCheck(<?= "'" . $drug["name"] . "', '" . $date . "'" ?>);" id="<?= $nova["number"] . $drug["name"] . $date ?>start">
                        </td>
                        <?php foreach ($novas as $nova): ?>
                            <td class="text-center">
                                <input type="number" min="0" width="30" height="100" class="text-center" value="<?= getRestockByDateAndDrug($date,$batch['id'],$nova['id']) ?>" onchange="pharmaCheck(<?= "'" . $drug["name"] . "', '" . $date . "'" ?>);" id="<?= $nova["number"] . $drug["name"] . $date ?>start">
                            </td>
                        <?php endforeach; ?>
                        <td id='<?= $drug["name"] . $date ?>' class="text-center">
                            <input id='<?= $drug["name"] . $date . "end"?>' type="number" min="0" width="30" height="100" class="text-center" value="<?= $pcheck ? $pcheck['end'] : '' ?>" onchange="pharmaCheck(<?= "'" . $drug["name"] . "', '" . $date . "'" ?>);" id="<?= $nova["number"] . $drug["name"] . $date ?>start">
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
