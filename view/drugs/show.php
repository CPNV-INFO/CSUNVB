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
<div class="float-right d-print-none d-inline">
    <button type='submit' class='btn btn-primary m-1 float-right' onclick="window.print()">Télécharger en PDF
    </button>
    <div class="float-right d-print-none">
        <?= slugBtns("drug", $drugsheet, $drugsheet['slug']) ?>
    </div>
</div>

<h5>
    Semaine <?= $drugsheet["week"] ?><br>
    Base : <?= $site['name'] ?><br>
    Status : <?= $drugsheet['displayname'] ?>
</h5>
<div class="d-flex justify-content-end d-print-none">
</div>

<?php if ($drugsheet['slug'] != "blank"): // We check if the drugsheet slug is "blank" or not to change the page to a preparation's page if it is?>

    <form action="?action=updateDrugSheet" method="POST">
        <button type="submit" class='btn btn-primary m-1 float-right' id="save" hidden>Enregistrer les données</button>
        <input type="hidden" name="drugsheetID" value="<?= $drugSheetID ?>">
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
                    <th>Pharma</th>
                    <?php foreach ($novas as $nova): ?>
                        <th><?= $nova["number"] ?></th>
                    <?php endforeach; ?>
                    <th>Spécial</th>
                    <th>pharma</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($drugs as $drug): ?>
                    <tr>
                        <td class="font-weight-bold"><?= $drug["name"] ?></td>
                        <td></td>
                        <?php foreach ($novas as $nova): ?>
                            <?php $ncheck = getNovaCheckByDateAndDrug($date, $drug['id'], $nova['id'], $drugsheet['id']); // not great practice, but it spares repeated queries on the db
                            if ($ncheck == false) $ncheck = array("start" => 0, "end" => 0);
                            ?>
                            <?php $UID = 'n' . $nova["number"] . 'd' . $drug["id"] . 'D' . $date; ?>
                            <?php if ($drugsheet['slug'] != "close"): // We check if the drugsheet is closed or not to change input to simple div ?>
                                <td id="<?= $UID ?>" class="text-center">
                                    <input type="number" min="0" class="text-center d-inline w-25 border-0 checkMorning"
                                           name="novaChecks[<?= $date ?>][<?= $nova['id'] ?>][<?= $drug['id'] ?>][start]"
                                           value="<?= (is_numeric($ncheck["start"]) ? $ncheck["start"] : '0') ?>"
                                           onchange="cellUpdate('<?= $UID ?>', 'start');"
                                           id="<?= $UID ?>start"
                                    > /
                                    <input type="number" min="0" class="text-center d-inline w-25 border-0 checkEvening"
                                           name="novaChecks[<?= $date ?>][<?= $nova['id'] ?>][<?= $drug['id'] ?>][end]"
                                           value="<?= (is_numeric($ncheck["end"]) ? $ncheck["end"] : '0') ?>"
                                           onchange="cellUpdate('<?= $UID ?>', 'end');"
                                           id="<?= $UID ?>end"
                                    >
                                </td>
                            <?php else: ?>
                                <td id="<?= $UID ?>" class="text-center">
                                    <div id="<?= $UID ?>start"
                                         class="mw-25 w-fit-content d-inline checkMorning"><?= (is_numeric($ncheck["start"]) == true ? $ncheck["start"] : '0') ?></div>
                                    /
                                    <div id="<?= $UID ?>end"
                                         class="mw-25 w-fit-content d-inline checkEvening"><?= (is_numeric($ncheck["end"]) == true ? $ncheck["end"] : '0') ?></div>
                                </td>
                            <?php endif; ?>
                            <?php array_push($UIDs, $UID);

                            ?>
                        <?php endforeach; ?>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php foreach ($batchesForSheetByDrugId[$drug["id"]] as $batch): ?>
                        <?php $UID = "pharma_" . 'b' . $batch['id'] . 'D' . $date; ?>
                        <?php $pcheck = getPharmaCheckByDateAndBatch($date, $batch['id'], $drugsheet['id']);
                        if ($pcheck == false) $pcheck = array("start" => 0, "end" => 0);
                        ?>
                        <tr>
                            <td class="text-right"><?= $batch['number'] ?></td>
                            <td class="text-center">

                                <?php if ($drugsheet['slug'] != "close"): // We check if the drugsheet is closed or not to change input to simple div    ?>

                                    <input type="number" min="0" class="text-center border-0  checkMorning w-50"
                                           name="pharmachecks[<?= $date ?>][<?= $batch['id'] ?>][start]"
                                           value="<?= (is_numeric($pcheck['start']) ? $pcheck['start'] : '0') ?>"
                                           onchange="cellUpdate('<?= $UID ?>', 'start');"
                                           id="<?= $UID ?>start">


                                <?php else: ?>
                                    <div class="text-center checkMorning mw-25 w-fit-content mx-auto"
                                         id="<?= $UID ?>start"><?= (is_numeric($pcheck['start']) ? $pcheck['start'] : '0') ?></div>

                                <?php endif; ?>
                            </td>
                            <?php foreach ($novas as $nova): ?>
                                <td class="text-center">
                                    <?php if ($drugsheet['slug'] != "close"): ?>
                                        <input type="number" min="0" class="text-center <?= $UID ?> restock border-0"
                                               name="restock[<?= $date ?>][<?= $batch['id'] ?>][<?= $nova['id'] ?>]"
                                               value="<?= (getRestockByDateAndDrug($date, $batch['id'], $nova['id']) + 0) //+0 auto converts to a number, even if null           ?>"
                                               onchange="cellUpdate('<?= $UID ?>')">
                                    <?php else: ?>
                                        <div class="<?= $UID ?> restock text-center"><?= (getRestockByDateAndDrug($date, $batch['id'], $nova['id']) ? getRestockByDateAndDrug($date, $batch['id'], $nova['id']) : '0')  //+0 auto converts to a number, even if null        ?></div>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                            <?php if ($drugsheet['slug'] != "close"): ?>
                            <td>
                                <div id='<?= $UID ?>special'
                                     class="w-100 text-center"><?= isset($sumsOfSpecialDrugOutByDateAndBatch[$date][$batch['id']]) ? $sumsOfSpecialDrugOutByDateAndBatch[$date][$batch['id']] : 0 ?></div>
                                <button type='button' class='btn btn-primary specialOutButton' data-toggle="modal"
                                        data-target="#specialCheckModal"
                                        onclick="showModalElementByDateAndBatch('<?= $date ?>',<?= $batch['id'] ?>,<?= $drugSheetID ?>,'<?= date("d.m.Y", strtotime($date))?>','<?=$batch['number']?>');">
                                    Plus
                                </button>
                            </td>
                            <?php else: ?>
                                <td class="text-center">
                                    <div id='<?= $UID ?>special'
                                         class="w-100 text-center"><?= isset($sumsOfSpecialDrugOutByDateAndBatch[$date][$batch['id']]) ? $sumsOfSpecialDrugOutByDateAndBatch[$date][$batch['id']] : 0 ?></div>
                                    <button type='button' class='btn btn-primary specialOutButton' data-toggle="modal"
                                            data-target="#specialCheckModal"
                                            onclick="showModalElementByDateAndBatch('<?= $date ?>',<?= $batch['id'] ?>,<?= $drugSheetID ?>,'<?= date("d.m.Y", strtotime($date))?>','<?=$batch['number']?>');">
                                        Plus
                                    </button>
                                </td>
                            <?php endif; ?>
                            <td id="<?= $UID ?>" class="text-center">
                                <?php if ($drugsheet['slug'] != "close"): ?>

                                    <input type="number" min="0" class="text-center border-0 checkEvening w-50"
                                           name="pharmachecks[<?= $date ?>][<?= $batch['id'] ?>][end]"
                                           value="<?= is_numeric($pcheck['end']) ? $pcheck['end'] : '0' ?>"
                                           onchange="cellUpdate('<?= $UID ?>', 'end');"
                                           id="<?= $UID ?>end">
                                <?php else: ?>

                                    <div class="text-center checkEvening mw-25 w-fit-content mx-auto"
                                         id="<?= $UID ?>end"><?= is_numeric($pcheck['end']) ? $pcheck['end'] : '0' ?></div>

                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php array_push($UIDs, $UID); ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <tr>
                    <td>Signature</td>
                    <td colspan="5" class="text-center">
                        <?php
                        $foundSignature = false;
                        foreach ($drugSignatures as $drugSignature) {
                            if ($drugSignature['day'] == ($date . " 00:00:00")) {
                                $foundSignature = $drugSignature;
                            }
                        }
                        if ($foundSignature !== false) {
                            $day = new DateTime($foundSignature['date']);

                            echo "Signé par " . $foundSignature['firstname'] . " " . $foundSignature['lastname'] . " le " . $day->format("d.m.Y") . " à " . $foundSignature['basename'];
                        } else {
                            if ($drugsheet['slug'] == "open" || $drugsheet['slug'] == "reopen") {
                                $day = new DateTime($date);
                                $today = new DateTime('now');
                                if ($today >= $day) {
                                    echo "<button type='button' class='btn btn-primary m-1 signDayButton' onclick='signDrugSheetDay(\"" . $date . "\"," . $drugSheetID . ")'>Signer</button>";
                                }
                            }
                        }
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        <?php endforeach; ?>
    </form>
    <div class="modal fade" id="specialCheckModal" tabindex="-1" role="dialog" aria-labelledby="specialCheckModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="specialCheckModalTitle">Sortie spéciale de stupéfiants du <span id="specialBatchOutDate"></span> pour le lot <span id="specialBatchOutBatch"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if ($drugsheet['slug'] != "close"): ?>
                    <section>
                        <form action="?action=newSpecialDrugOut" method="POST">
                            <input id="specialCheckInputDate" type="text" name="date" hidden required>
                            <input id="specialCheckInputBatchId" type="number" name="batchId" hidden required>
                            <input id="specialCheckInputSheetId" type="number" name="sheetId" hidden required>
                            <table id="specialCheckInputTable">
                                <tr class="w-100">
                                    <th>Quantité</th>
                                    <td><input type="number" name="quantity" min="1" step="1"
                                               value="0"
                                               required class="h-100"></td>
                                </tr>
                                <tr>
                                    <th>Admin à notifier</th>
                                    <td>
                                        <select name="admin" required>
                                            <option value="" disabled selected></option>
                                            <?php foreach ($adminsWithNumber as $admin): ?>
                                                <option value="<?= $admin['id'] ?>"><?= $admin['initials'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Raison</th>
                                    <td class="w-75"><textarea name="comment" class="w-100" required></textarea></td>
                                </tr>
                                <tr>
                                    <td rowspan="3">
                                        <button type="submit" class='btn btn-primary m-1'>Envoyer</button>
                                    </td>
                                </tr>
                            </table>

                        </form>
                    </section>
                    <?php endif; ?>
                    <section id="noSpecialOutData" hidden>
                        Aucune sortie spéciale n'a été effectuée pour ce batch à cette date
                    </section>
                    <section>
                        <?php foreach ($specialDrugsOutByDateAndBatch as $specialDrugsOutDateKey => $specialDrugsOutDateData): ?>
                            <?php foreach ($specialDrugsOutDateData as $specialDrugsOutBatchKey => $specialDrugsOutBatchData): ?>
                                <table id="tableSpecialD<?= $specialDrugsOutDateKey ?>B<?= $specialDrugsOutBatchKey ?>"
                                       class="table table-bordered specialDrugOutTable" hidden>
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Quantité</th>
                                        <th>Commentaire</th>
                                        <th>Admin Prévenu</th>
                                        <th>Par</th>
                                    </tr>
                                    </thead>
                                    <tbody class="overflow-auto">
                                    <?php foreach ($specialDrugsOutBatchData as $specialDrugOut): ?>
                                        <tr>
                                            <td><?= date("d.m.Y H:i:s", strtotime($specialDrugOut['execution_date'])) ?></td>
                                            <td><?= $specialDrugOut['quantity'] ?></td>
                                            <td><?= $specialDrugOut['comment'] ?></td>
                                            <td><?= $specialDrugOut['notified_admin'] ?></td>
                                            <td><?= $specialDrugOut['user'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>

                                </table>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <div id="test2" hidden>2</div>
                        <div id="test3" hidden>3</div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>

    <div class="d-flex flex-row float-right d-print-none">
        <!-- If user is admin and sheet is "blank" then show modification button -->
        <?php if (ican("modifySheet") && $drugsheet['slug'] == "blank") : ?>
            <?php if ($edition) :
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


    <?php if (ican("modifySheet") && $edition) : ?> <!-- Zone d'ajout de nouvelle tâche -->
        <div class="d-print-none"
             style="border: solid; padding: 5px; margin: 2px; margin-top: 45px; margin-bottom: 15px;">
            <form method="POST" action="?action=addBatchesToDrugSheet" class="d-flex justify-content-between edit-form">
                <div class="d-flex">
                    <div>
                        <label for="drugToAddList" style="padding: 0 15px">stupéfiant </label>
                        <select name="drugToAddList" id="drugToAddList" class='missingDrugChoice' required
                                style="width: 100px; font-size: " onchange="drugListUpdate()">
                            <option value="default"></option>
                            <?php foreach ($drugsWithUsableBatches as $drugWithUsableBatches) : ?>
                                <option name="Drug"
                                        value="<?= $drugWithUsableBatches['name'] ?>"><?= $drugWithUsableBatches['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <label for="batchToAddList" style="padding: 0 15px">lot </label>
                        <select name="batchToAddList" id="batchToAddList" style="width: 100px;" required
                                class="missingDrugChoice float-right" onchange="batchSelectionMissing()">
                            <option value="default"></option>
                            <?php foreach ($usableBatches as $usableBatch): ?>
                                <option name="Batch" value="<?= $usableBatch['id'] ?>" hidden
                                        class="drug_<?= $usableBatch['name'] ?>"><?= $usableBatch['number'] . " - " . $usableBatch['state'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                </div>
                <input type="hidden" name="drugSheetID" value="<?= $drugSheetID ?>">
                <button type="submit" id="addBatchBtn" class='btn btn-primary m-1' disabled>Ajouter le lot</button>
            </form>
            <form method="POST" action="?action=addNovasToDrugSheet" class="d-flex justify-content-between edit-form">
                <div class="d-flex">
                    <div>
                        <label for="novaToAddList" style="padding: 0 15px">Ambulance </label>
                        <select name="novaToAddList" id="novaToAddList" class='missingNovaChoice' required
                                style="width: 100px;" onchange="NovaListUpdate()">
                            <option value="default"></option>
                            <?php foreach ($unusedNovas as $unusedNova) : ?>
                                <option name="Nova"
                                        value="<?= $unusedNova['number'] ?>"><?= $unusedNova['number'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                </div>
                <input type="hidden" name="drugSheetID" value="<?= $drugSheetID ?>">
                <button type="submit" id="addNovaBtn" class='btn btn-primary m-1' disabled>Ajouter l'ambulance</button>
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
                <th>
                    <span class="d-inline novacount"><?= $nova["number"] ?></span>
                    <?php if (ican("modifySheet") && $edition) : ?>
                        <form method="POST" action="?action=removeNovaFromDrugSheet"
                              onsubmit="return confirm('Est ce que vous voulez vraiment retirer l\'ambulance <?= $nova["number"] ?> du rapoort?');"
                              class="d-inline">
                            <input type="hidden" name="nova" value="<?= $nova["number"] ?>">
                            <input type="hidden" name="drugSheetID" value="<?= $drugSheetID ?>">
                            <button type="submit" id="removeNovaBtn" class='btn trashButton'><i
                                        class="fas fa-trash"></i></button>
                        </form>
                    <?php endif; ?>
                </th>
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
                    <td class="text-right">
                        <span class="d-inline batchcount"><?= $batch['number'] ?> </span>
                        <?php if (ican("modifySheet") && $edition) : ?>
                            <form method="POST" action="?action=removeBatchFromDrugSheet"
                                  onsubmit="return confirm('Est ce que vous voulez vraiment retirer le lot <?= $batch['number'] ?> du rapoort?');"
                                  class="d-inline">
                                <input type="hidden" name="batch" value="<?= $batch['id'] ?>">
                                <input type="hidden" name="drugSheetID" value="<?= $drugSheetID ?>">
                                <button type="submit" id="removeBatchBtn" class='btn trashButton'><i
                                            class="fas fa-trash"></i></button>
                            </form>
                        <?php endif; ?>
                    </td>
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
    let UIDS = [];
    var defineUids = function () {


        <?php
        foreach ($UIDs as $UID) {
            echo "UIDS.push('" . $UID . "');\n";
        }
        ?>
    }
    checkForEnable();
</script>
<span></span>

<?php
$content = ob_get_clean();
require GABARIT;
?>
