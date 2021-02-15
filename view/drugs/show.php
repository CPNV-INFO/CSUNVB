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

<?php if($drugsheet['slug'] != "blank"): // We check if the drugsheet slug is "blank" or not to change the page to a preparation's page if it is?>
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
            <?php foreach ($batchesForSheetByDrugId[$drug["id"]] as $batch): ?>
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
<?php else: ?>

    <div class="d-flex flex-row float-right d-print-none"> <!-- If user is admin and sheet is "blank" then show modification button -->
        <?php if(ican ("modifySheet") && $drugsheet['slug'] == "blank") : ?>
            <?php if($edition) :
                $text = "Quitter édition";
            else:
                $text = "Mode édition";
            endif; ?>
            <form action="?action=drugSheetEditionMode" method="POST">
                <input type="hidden" name="drugsheetID" value="<?= $drugSheetID ?>">
                <input type="hidden" name="edition" value="<?= $edition ?>">
                <button type="submit" class='btn btn-warning m-1 float-right'><?= $text ?></button>
            </form>
        <?php endif; ?>
        <?= slugBtns("drug", $drugsheet, $drugsheet['slug']) ?>
    </div>


    <?php if(ican ("modifySheet") && $edition) : ?> <!-- Zone d'ajout de nouvelle tâche -->
        <div class="d-print-none" style="border: solid; padding: 5px; margin: 2px; margin-top: 15px; margin-bottom: 15px">
            <form method="POST" action="?action=addBatchesToDrugSheet" class="d-flex justify-content-between">
                <div class="d-flex">
                    <div>
                        <label for="drugToAddList" style="padding: 0 15px">stupéfiant </label>
                        <select name="day" id="drugToAddList" class='missingTasksChoice' style="width: 100px;">
                            <option value="default"></option>
                            <?php foreach ($DrugsWithUsableBatch as $index => $DrugWithUsableBatch) : ?>
                                <option name="Drug" value="<?= $index + 1 ?>" ><?= $DrugWithUsableBatch['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <label for="missingTaskTime" style="padding: 0 15px">lot </label>
                        <select name="dayTime" id="missingTaskTime" style="width: 100px;" class="missingTasksChoice float-right">
                            <option value="default"></option>
                            <option name="dayTime" value="1" >Jour</option>
                            <option name="dayTime" value="0" >Nuit</option>
                        </select>
                    </div>


                </div>
                <input type="hidden" name="drugSheetID" value="<?= $drugSheetID ?>">
                <button type="submit" id="addBatchBtn" class='btn btn-primary m-1' disabled>Ajouter le lot</button>
            </form>
        </div>
    <?php endif; ?>


    <table border="1" class="table table-bordered">
        <thead class="thead-dark">
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
                    <td></td>
                <?php endforeach; ?>
                <td></td>
            </tr>
            <?php foreach ($batchesForSheetByDrugId[$drug["id"]] as $batch): ?>
                <tr>
                    <td class="text-right"><?= $batch['number'] ?></td>
                    <td class="text-center">
                    </td>

                    <?php foreach ($novas as $nova): ?>
                        <td></td>
                    <?php endforeach; ?>
                    <td></td>
                </tr>

            <?php endforeach; ?>

        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
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
