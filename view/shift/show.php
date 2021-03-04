<?php
ob_start();
$title = "CSU-NVB - Remise de garde";
?>
<div>
    <?= (ican("consultLog")) ? "<a href='?action=shiftLog&id=" . $shiftsheet['id'] . "'><i class='fas fa-history fa-2x logIcon'></i></a>" : "" ?>
    <h1>Remise de Garde </h1>
    <h2>Jour : <?= date('d.m.Y', strtotime($shiftsheet['date'])) ?> - Base de <?= $shiftsheet['baseName'] ?>
        [<?= $shiftsheet['displayname'] ?>]
        <?= ($shiftsheet['status'] == 'close') ? ' par ' . $shiftsheet['closeBy'] : '' ?>
    </h2>
    <input type="hidden" id="shiftDate" value="<?= $shiftsheet['date'] ?>"><!-- used to get date in javascrpt -->
    <div class='d-flex justify-content-end d-print-none'>
        <?= slugBtns("shift", $shiftsheet, $shiftsheet["status"]) ?>
        <form method='POST'>
            <input type='hidden' name='id' value='" . $sheet["id"] . "'>
            <input type='hidden' name='newSlug' value='open'>
            <button type='submit' class='btn btn-primary m-1' onclick="print_page()">Télécharger en PDF</button>
        </form>

        <form>
            <input type="hidden" name="action" value="listshift">
            <input type="hidden" name="id" value="<?= $shiftsheet["base_id"] ?>">
            <button type="submit" class='btn btn-primary m-1 float-right'>Retour à la liste</button>
        </form>
    </div>
</div>

<div class="container">
    <form action="?action=updateShift&id=<?= $shiftsheet['id'] ?>" method="POST">
        <input type=hidden name="id" value= <?= $shiftsheet['id'] ?>>
        <div class="row">
            <div class="col-auto">
                <table>
                    <tr>
                        <td class=""></td>
                        <td class="text-center" style="width: 50px;"><strong>Jour</strong></td>
                        <td class="text-center" style="width: 50px;"><strong>Nuit</strong></td>
                    </tr>
                    <tr>
                        <td class=" text-right">Novas</td>
                        <td class=" text-center">
                            <?php if ($enableshiftsheetUpdate) : ?>
                                <select name="novaDay" class="SH_dropdownInfo">
                                    <?= ($shiftsheet['novaDay'] == NULL) ? '<option value="NULL" selected></option>' : '' ?>
                                    <?php foreach ($novas as $nova): ?>
                                        <option value="<?= $nova['id'] ?>" <?= ($shiftsheet['novaDay'] == $nova['number']) ? 'selected' : '' ?>><?= $nova['number'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <?= $shiftsheet['novaDay'] ?>
                            <?php endif; ?>
                        </td>
                        <td class=" text-center">
                            <?php if ($enableshiftsheetUpdate) : ?>
                                <select name="novaNight" class="SH_dropdownInfo">
                                    <?= ($shiftsheet['novaNight'] == NULL) ? '<option value="NULL" selected></option>' : '' ?>
                                    <?php foreach ($novas as $nova): ?>
                                        <option value="<?= $nova['id'] ?>" <?= ($shiftsheet['novaNight'] == $nova['number']) ? 'selected' : '' ?>><?= $nova['number'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <?= $shiftsheet['novaNight'] ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class=" text-right">Responsable</td>
                        <td class="text-center">
                            <?php if ($enableshiftsheetUpdate) : ?>
                                <select name="bossDay" class="SH_dropdownInfo">
                                    <?= ($shiftsheet['bossDay'] == NULL) ? '<option value="NULL" selected></option>' : '' ?>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= ($shiftsheet['bossDay'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <?= $shiftsheet['bossDay'] ?>
                            <?php endif; ?>
                        </td>
                        <td class=" text-center">
                            <?php if ($enableshiftsheetUpdate) : ?>
                                <select name="bossNight" class="SH_dropdownInfo">
                                    <?= ($shiftsheet['bossNight'] == NULL) ? '<option value="NULL" selected></option>' : '' ?>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= ($shiftsheet['bossNight'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <?= $shiftsheet['bossNight'] ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class=" text-right">Équipier</td>
                        <td class=" text-center">
                            <?php if ($enableshiftsheetUpdate) : ?>
                                <select name="teammateDay" class="SH_dropdownInfo">
                                    <?= ($shiftsheet['teammateDay'] == NULL) ? '<option value="NULL" selected></option>' : '' ?>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= ($shiftsheet['teammateDay'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <?= $shiftsheet['teammateDay'] ?>
                            <?php endif; ?>
                        </td>
                        <td class=" text-center">
                            <?php if ($enableshiftsheetUpdate) : ?>
                                <select name="teammateNight" class="SH_dropdownInfo">
                                    <?= ($shiftsheet['teammateNight'] == NULL) ? '<option value="NULL" selected></option>' : '' ?>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= ($shiftsheet['teammateNight'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else : ?>
                                <?= $shiftsheet['teammateNight'] ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col" id="SH_updateInfoBtn">
                <button type="submit" class="btn btn-primary m-1 pull-right">Valider</button>
            </div>
        </div>
    </form>
</div>
<div class="container">
    <?php foreach ($sections as $section): ?>
        <div class="row SH_sectionName"><?= $section["title"] ?></div>
        <table class="table table-bordered float-left">
            <thead class="thead-dark">
            <th></th>
            <th class="SH_checkCase">Jour</th>
            <th class="SH_checkCase">Nuit</th>
            <th>Remarques</th>
            </thead>
            <tbody>
            <?php
            foreach ($section["actions"] as $action): ?>
                <tr value='<?= $action['id'] ?>'>
                    <!-- actionName Cell-->
                    <td class="SH_actionCase">
                        <form action="?action=removeActionForShift&id=<?= $shiftsheet['id'] ?>" method="post">
                            <?php if ($shiftsheet['status'] == "blank" && $_SESSION['user']['admin'] == true): ?>

                                <input type="hidden" name="model" value="<?= $shiftsheet['model'] ?>">
                                <input type="hidden" name="action" value="<?= $action['id'] ?>">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i>
                                </button>
                            <?php endif; ?>
                            <div class="SH_actionName"><?= $action['text'] ?></div>
                        </form>
                    </td>
                    <?php if ($enableshiftsheetFilling): ?>
                        <!-- Check for the day -->
                        <td class="SH_checkCase">
                            <?php if (count($action["checksDay"]) == 0): ?>
                                <button onclick="shiftCheckModal('<?= $shiftsheet['date'] ?>','<?= $action['text'] ?>',<?= $action['id'] ?>,<?= $shiftsheet['id'] ?>,1)"
                                        class="btn btn-warning toggleShiftModal">A Valider
                                </button>
                            <?php else: ?>
                                <button onclick="shiftUnCheckModal('<?= $shiftsheet['date'] ?>','<?= $action['text'] ?>',<?= $action['id'] ?>,<?= $shiftsheet['id'] ?>,1)"
                                        class="btn btn-success toggleShiftModal">
                                    Validé Par
                                    <div class="text-success bg-white rounded mt-1">
                                        <?php foreach ($action["checksDay"] as $check): ?>
                                            <?= $check["initials"] ?>
                                        <?php endforeach; ?>
                                    </div>
                                </button>
                            <?php endif; ?>
                        </td>
                        <!-- Check for the night -->
                        <td class="SH_checkCase">
                            <?php if (count($action["checksNight"]) == 0): ?>
                                <button onclick="shiftCheckModal('<?= $shiftsheet['date'] ?>','<?= $action['text'] ?>',<?= $action['id'] ?>,<?= $shiftsheet['id'] ?>,0)"
                                        class="btn btn-warning toggleShiftModal">A Valider
                                </button>
                            <?php else: ?>
                                <button onclick="shiftUnCheckModal('<?= $shiftsheet['date'] ?>','<?= $action['text'] ?>',<?= $action['id'] ?>,<?= $shiftsheet['id'] ?>,0)"
                                        class="btn btn-success toggleShiftModal">
                                    Validé Par
                                    <div class="text-success bg-white rounded mt-1">
                                        <?php foreach ($action["checksNight"] as $check): ?>
                                            <?= $check["initials"] ?>
                                        <?php endforeach; ?>
                                    </div>
                                </button>
                            <?php endif; ?>
                        </td>
                        <!-- Comments for the action -->
                        <td>
                            <div id="commentList<?= $action['id'] ?>">
                                <?php foreach ($action["comments"] as $comment): ?>
                                    <div class="<?= ($comment['carryOn'] == 1 and $comment['endOfCarryOn'] == null) ? 'carry' : 'notCarry' ?>"
                                         id="comment-<?= $comment['id'] ?>">
                                        <!-- CarryOn button -->
                                        <button class="removeCarryOnBtn carried" value=<?= $comment['id'] ?>>
                                            <i class="fas fa-thumbtack fa-lg" style="color:#000000"></i>
                                        </button>
                                        <button class="addCarryOnBtn addCarry" value=<?= $comment['id'] ?>>
                                            <i class="fas fa-thumbtack fa-rotate-90 fa-lg" style="color:#777777"></i>
                                        </button>
                                        <!-- Comment -->
                                        <strong>[ <?= $comment['initials'] ?>
                                            - <?= date('H:i', strtotime($comment['time'])) ?> <?= ($comment['carryOn'] == 1) ? date('/  d.m.Y ', strtotime($comment['time'])) : "" ?>
                                            ] :</strong>
                                        <?= $comment['message'] ?>
                                        <hr>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button onclick="shiftCommentModal('<?= date('d.m.Y', strtotime($shiftsheet['date'])) ?>','<?= $action['text'] ?>',<?= $action['id'] ?>,<?= $shiftsheet['id'] ?>)"
                                    class="btn btn-secondary btn-block m-1 d-print-none addShiftComment"
                                    style="width:200px;"> Nouveau commentaire
                            </button>
                        </td>
                    <?php else: ?>
                        <td <?= ($shiftsheet['status'] == 'close'and count($action["checksDay"]) == 0 ) ? 'class="incompleteTask"' : '' ?> >
                            <?php foreach ($action["checksDay"] as $check): ?>
                                <?= $check["initials"] ?>
                            <?php endforeach; ?>
                        </td>
                        <td <?= ($shiftsheet['status'] == 'close'and count($action["checksNight"]) == 0 ) ? 'class="incompleteTask"' : '' ?> >
                            <?php foreach ($action["checksNight"] as $check): ?>
                                <?= $check["initials"] ?>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <?php foreach ($action["comments"] as $comment): ?>
                                [ <?= $comment['initials'] ?>, <?= $comment['time'] ?> ] : <?= $comment['message'] ?>
                                <br>
                            <?php endforeach; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            <?php if ($shiftsheet['status'] == "blank" && $_SESSION['user']['admin'] == true): ?>
                <tr>
                    <td colspan="4" style="padding: 0px;">
                        <div>
                            <div class="float-left">
                                <form action="?action=addActionForShift&id=<?= $shiftsheet['id'] ?>" method="post">
                                    <input type="hidden" name="model" value="<?= $shiftsheet['model'] ?>">
                                    <button type="submit" class='btn btn-success m-1'
                                    ">Ajouter</button>
                                    <select name="actionID">
                                        <?php foreach ($section["unusedActions"] as $action): ?>
                                            <option value="<?= $action["id"] ?>"><?= $action["text"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </div>
                            <div class="float-left" style="margin-left: 50px">
                                <form action="?action=creatActionForShift&id=<?= $shiftsheet['id'] ?>" method="post">
                                    <input type="hidden" name="model" value="<?= $shiftsheet['model'] ?>">
                                    <input type="hidden" name="section" value="<?= $section['id'] ?>">
                                    <button type="submit" class='btn btn-success m-1'
                                    ">Créer</button>
                                    <input type="text" name="actionToAdd" value="" style="margin : 6px;">
                                </form>
                            </div class="float-left">
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>
</div>
<div style='clear: both;  font-size: 14px; font-family: Helvetica; color: #8d8d8d; background: transparent;'>
    Modèle utilisé :
    <?php if ($model["name"] == ""): ?>
        Aucun
    <?php else: ?>
        <?= $model["name"] ?>
    <?php endif; ?>
    <div class="float-right d-print-none">
        <div class="d-flex flex-row">
            <?php if ($model["suggested"] == 0) : ?>
                <?php if ($model["name"] != "") : ?>
                    <button class="btn btn-primary m-1"
                            onclick="reAddShiftModel(<?= $shiftsheet["model"] ?>, '<?= $model["name"] ?>',<?= $shiftsheet['id'] ?>)">
                        Ré-activer le modèle
                    </button>
                <?php else : ?>
                    <button class="btn btn-primary m-1"
                            onclick="saveShiftModel(<?= $shiftsheet['id'] ?>,<?= $shiftsheet["model"] ?>)">
                        Enregistrer comme modèle
                    </button>
                <?php endif; ?>
            <?php else : ?>
                <?php if ($model["name"] != "Vide") : ?>
                    <button class="btn btn-primary m-1"
                            onclick="disableShiftModel(<?= $shiftsheet["model"] ?>, <?= $model["name"] ?>,<?= $shiftsheet['id'] ?>)">
                        Oublier le modèle
                    </button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="js/shift.js"></script>
<?php
$content = ob_get_clean();
require GABARIT;
?>
