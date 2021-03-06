<?php
/**
 * Auteur: David Roulet / Fabien Masson
 * Date: Aril 2020
 **/

$title = "CSU-NVB - Stupéfiants";
ob_start();
?>
<script>
    var drugsheetmode = '<?= $drugsheet["slug"]; ?>';
</script>
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
<button class='btn btn-primary m-1 float-right' id="save" hidden onclick="sendData()">Enregistrer les données</button>
<div class="float-right d-print-none">
    <?= slugBtns("drug", $drugsheet, $drugsheet['slug']) ?>
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
                    <?php $ncheck = getNovaCheckByDateAndDrug($date, $drug['id'], $nova['id'], $drugsheet['id']); // not great practice, but it spares repeated queries on the db
                    if($ncheck == false) $ncheck = array("start" => 0,"end"=>0);
                    ?>
                    <?php $UID = 'n' . $nova["number"] . 'd' . $drug["id"] . 'D' . $date ?>
                    <?php if($drugsheet['slug'] != "close"): // We check if the drugsheet is closed or not to change input to simple div ?>
                    <td id="<?= $UID ?>">
                        <input  type="number" min="0" class="text-center"
                                value="<?= (is_numeric($ncheck["start"]) ? $ncheck["start"] : '0') ?>"
                                onchange="cellUpdate('<?= $UID ?>', 'start');"
                                id="<?= $UID ?>start"
                        >
                        <input  type="number" min="0" class="text-center"
                                value="<?= (is_numeric($ncheck["end"]) ? $ncheck["end"] : '0') ?>"
                                onchange="cellUpdate('<?= $UID ?>', 'end');"
                                id="<?= $UID ?>end"
                    >
                    </td>
                    <?php else: ?>
                    <td id="<?= $UID ?>" class="text-center">
                        <div id="<?= $UID ?>start" class="w-25 d-inline"><?= (is_numeric($ncheck["start"]) == true ? $ncheck["start"] : '0') ?></div> / <div id="<?= $UID ?>end" class="w-25 d-inline"><?= (is_numeric($ncheck["end"]) == true ? $ncheck["end"] : '0') ?></div>
                    </td>
                    <?php endif; ?>
                <?php array_push($UIDs, $UID); ?>
                <?php endforeach; ?>
                <td></td>
            </tr>
            <?php foreach ($batchesByDrugId[$drug["id"]] as $batch): ?>
                <?php $UID = "pharma_" . 'b' . $batch['id'] . 'D' . $date ?>
                <?php $pcheck = getPharmaCheckByDateAndBatch($date, $batch['id'], $drugsheet['id']);
                if($pcheck == false) $pcheck = array("start" => 0,"end"=>0);
                ?>
                <tr>
                    <td class="text-right"><?= $batch['number'] ?></td>
                    <td class="text-center">
                        <?php if($drugsheet['slug'] != "close"): // We check if the drugsheet is closed or not to change input to simple div?>
                        <input  type="number" min="0" class="text-center"
                                value="<?= (is_numeric($pcheck['start']) ? $pcheck['start'] : '0') ?>"
                                onchange="cellUpdate('<?= $UID ?>', 'start');"
                                id="<?= $UID ?>start"

                        >
                    </td>
                    <?php else: ?>
                        <div class="text-center" id="<?= $UID ?>start"><?= (is_numeric($pcheck['start']) ? $pcheck['start'] : '0') ?></div>

                    <?php endif; ?>
                    <?php foreach ($novas as $nova): ?>
                        <td class="text-center">
                            <?php if ($drugsheet['slug'] != "close"): ?>
                                <input type="number" min="0" class="<?= $UID ?> nova text-center"
                                        value="<?= (getRestockByDateAndDrug($date, $batch['id'], $nova['id']) + 0) //+0 auto converts to a number, even if null ?>"
                                        onchange="cellUpdate('<?= $UID ?>')"

                                >
                            <?php else: ?>
                                <div class="<?= $UID ?> nova text-center"><?= (getRestockByDateAndDrug($date, $batch['id'], $nova['id']) ? getRestockByDateAndDrug($date, $batch['id'], $nova['id']) : '0') /*(getRestockByDateAndDrug($date, $batch['id'], $nova['id']) + 0) */ //+0 auto converts to a number, even if null ?></div>
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                    <td id="<?= $UID ?>" class="text-center">
                        <?php if ($drugsheet['slug'] != "close"): ?>

                            <input type="number" min="0" class="text-center"
                                   value="<?= is_numeric($pcheck['end']) ? $pcheck['end'] : '0' ?>" class="text-center"
                                   onchange="cellUpdate('<?= $UID ?>', 'end');"
                                   id="<?= $UID ?>end"

                            >
                        <?php else: ?>

                            <div class="text-center" id="<?= $UID ?>end"><?= is_numeric($pcheck['end']) ? $pcheck['end'] : '0' ?></div>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php array_push($UIDs, $UID); ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <tr>
            <td>Signature</td>
            <td colspan="5"></td>
        </tr>
        </tbody>
    </table>
<?php endforeach; ?>
<script>
<?php
        foreach ($UIDs as $UID) {
            echo "drugCheck('" . $UID . "');\n";
        }
?>
</script>
<?php
$content = ob_get_clean();
require GABARIT;
?>
