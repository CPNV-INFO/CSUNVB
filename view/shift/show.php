<?php
ob_start();
$title = "CSU-NVB - Remise de garde";
?>
<input type="hidden" id="shiftDate" value="<?= $shiftsheet['date'] ?>"><!-- used to get date in javascrpt -->
<input type="hidden" id="sheetID" value="<?= $shiftsheet['id'] ?>"><!-- used to get id in javascrpt -->
<div class="float-right d-print-none d-inline">
    <div>
        <div class="d-print-none d-inline">
            <?= $enableStateChange ? slugBtns("shift", $shiftsheet, $shiftsheet["status"]) : '' ?>
            <button class="btn blueBtn d-inline m-1" onclick="print_page()"><i class="fas fa-file-pdf fa-lg"></i>
            </button>
            <form method="POST" class="d-inline" action='?action=shiftLog&id=<?= $shiftsheet['id'] ?>'>
                <button type="submit" class="btn blueBtn m-1"><i class="fas fa-history fa-lg"></i></button>
            </form>
        </div>
    </div>
</div>
<h5>
    Date : <?= date('d.m.Y', strtotime($shiftsheet['date'])) ?><br>
    Base : <?= $shiftsheet['baseName'] ?><br>
    Status : <?= $shiftsheet['displayname'] ?> <?= ($shiftsheet['status'] == 'close') ? ' par ' . $shiftsheet['closeBy'] : '' ?>
</h5>

<div>
    <div class="row">
        <div class="row align-items-center">
            <?php foreach ($shiftsheet['teamDay'] as $team): ?>
                <div data-team="<?= $team["team_id"] ?>" style="margin-bottom: 5px">
                    <div class="text-center selectForDay first">
                        <?php if ($enableDataUpdate) : ?>
                            <select name="nova" class="SH_dropdownInfo">
                                <?= ($team['nova'] == NULL) ? '<option value="NULL" selected disabled>Nova</option>' : '' ?>
                                <?php foreach ($novas as $nova): ?>
                                    <option value="<?= $nova['id'] ?>" <?= ($team['nova'] == $nova['number']) ? 'selected' : '' ?>><?= $nova['number'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else : ?>
                            <?= (isset($team["nova"])) ? $team["nova"] : '-' ?>
                        <?php endif; ?>
                    </div>
                    <div class="text-center selectForDay">
                        <?php if ($enableDataUpdate) : ?>
                            <select name="boss" class="SH_dropdownInfo">
                            <?= ($team['boss'] == NULL) ? '<option value="NULL" selected disabled>Resp.</option>' : '' ?>
                            <?php foreach ($activUsers as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= ($team['boss'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                            <?php endforeach; ?>
                            <option disabled="disabled">----</option>
                            <?php foreach ($inActivUsers as $user): ?>
                                <option style="color: gray" value="<?= $user['id'] ?>" <?= ($team['boss'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                            <?php endforeach; ?>
                            </select><?php else : ?>
                            <?= (isset($team['boss'])) ? $team['boss'] : '-' ?>
                        <?php endif; ?>
                    </div>
                    <div class="text-center selectForDay last">
                        <?php if ($enableDataUpdate) : ?>
                            <select name="teammate" class="SH_dropdownInfo">
                                <?= ($team['teammate'] == NULL) ? '<option value="NULL" selected disabled>Equi.</option>' : '' ?>
                                <?php foreach ($activUsers as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= ($team['teammate'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                                <?php endforeach; ?>
                                <option disabled="disabled">----</option>
                                <?php foreach ($inActivUsers as $user): ?>
                                    <option style="color: gray" value="<?= $user['id'] ?>" <?= ($team['teammate'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else : ?>
                            <?= (isset($team['teammate'])) ? $team['teammate'] : '-' ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if ($enableDataUpdate) : ?>
                <div style="align-items: center; margin-bottom: 5px" class="d-flex">
                    <div class="flex-container column" style="margin: 5px;align-items: center; -webkit-align-items: center; ">
                        <div class="flex-item" style="margin-bottom: 5px">
                            <form method='POST' class="flex-item"
                                  action='?action=addTeamForShift&id=<?= $shiftsheet['id'] ?>'>
                                <input type="hidden" name="day" value="1">
                                <button type="submit" class="btn" style="background-color: lightblue">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        </div>

                        <?php if (count($shiftsheet['teamDay']) > 1) : ?>
                            <div class="flex-item">
                                <form method='POST' class="flex-item"
                                      action='?action=removeTeamForShift&id=<?= $shiftsheet['id'] ?>'>
                                    <input type="hidden" name="day" value="1">
                                    <button type="submit" class="btn" style="background-color: lightblue">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="row align-items-center">
            <?php foreach ($shiftsheet['teamNight'] as $team): ?>
                <div data-team="<?= $team["team_id"] ?>" style="margin-bottom: 5px">
                    <div class="text-center selectForNight first">
                        <?php if ($enableDataUpdate) : ?>
                            <select name="nova" class="SH_dropdownInfo">
                                <?= ($team['nova'] == NULL) ? '<option value="NULL" selected disabled>Nova</option>' : '' ?>
                                <?php foreach ($novas as $nova): ?>
                                    <option value="<?= $nova['id'] ?>" <?= ($team['nova'] == $nova['number']) ? 'selected' : '' ?>><?= $nova['number'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else : ?>
                            <?= (isset($team["nova"])) ? $team["nova"] : '-' ?>
                        <?php endif; ?>
                    </div>
                    <div class="text-center selectForNight">
                        <?php if ($enableDataUpdate) : ?>
                            <select name="boss" class="SH_dropdownInfo">
                                <?= ($team['boss'] == NULL) ? '<option value="NULL" selected disabled>Resp.</option>' : '' ?>
                                <?php foreach ($activUsers as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= ($team['boss'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                                <?php endforeach; ?>
                                <option disabled="disabled">----</option>
                                <?php foreach ($inActivUsers as $user): ?>
                                    <option style="color: gray" value="<?= $user['id'] ?>" <?= ($team['boss'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else : ?>
                            <?= (isset($team['boss'])) ? $team['boss'] : '-' ?>
                        <?php endif; ?>
                    </div>
                    <div class="text-center selectForNight last">
                        <?php if ($enableDataUpdate) : ?>
                            <select name="teammate" class="SH_dropdownInfo">
                                <?= ($team['teammate'] == NULL) ? '<option value="NULL" selected disabled>Equi.</option>' : '' ?>
                                <?php foreach ($activUsers as $user): ?>
                                    <option value="<?= $user['id'] ?>" <?= ($team['teammate'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                                <?php endforeach; ?>
                                <option disabled="disabled">----</option>
                                <?php foreach ($inActivUsers as $user): ?>
                                    <option style="color: gray" value="<?= $user['id'] ?>" <?= ($team['teammate'] == $user['initials']) ? 'selected' : '' ?>><?= $user['initials'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else : ?>
                            <?= (isset($team['teammate'])) ? $team['teammate'] : '-' ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if ($enableDataUpdate) : ?>
                <div style="align-items: center;display: flex;margin-bottom: 5px" class="d-flex">
                    <div class="flex-container column" style="margin: 5px;align-items: center; -webkit-align-items: center; ">
                        <div class="flex-item" style="margin-bottom: 5px">
                            <form method='POST' class="flex-item"
                                  action='?action=addTeamForShift&id=<?= $shiftsheet['id'] ?>'>
                                <input type="hidden" name="day" value="0">
                                <button type="submit" class="btn btn-dark">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        </div>

                        <?php if (count($shiftsheet['teamNight']) > 1) : ?>
                            <div class="flex-item">
                                <form method='POST' class="flex-item"
                                      action='?action=removeTeamForShift&id=<?= $shiftsheet['id'] ?>'>
                                    <input type="hidden" name="day" value="0">
                                    <button type="submit" class="btn btn-dark">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div>
    <?php foreach ($sections as $section): ?>
        <div class="SH_sectionName"><?= $section["title"] ?></div>
        <table class="table table-bordered SH_table">
            <thead class="thead-dark">
            <th class="SH_actionCase"></th>
            <th class="SH_checkCase">Jour</th>
            <th class="SH_checkCase">Nuit</th>
            <th class="SH_comment">Remarques</th>
            </thead>
            <tbody>
            <?php
            foreach ($section["actions"] as $action): ?>
                <tr value='<?= $action['id'] ?>'>
                    <!-- actionName Cell-->
                    <td class="SH_actionCase">
                        <form action="?action=removeActionForShift&id=<?= $shiftsheet['id'] ?>" method="post">
                            <?php if ($enableStructureChange): ?>
                                <input type="hidden" name="model" value="<?= $shiftsheet['model'] ?>">
                                <input type="hidden" name="action" value="<?= $action['id'] ?>">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i>
                                </button>
                            <?php endif; ?>
                            <div class="SH_actionName"><?= $action['text'] ?></div>
                        </form>
                    </td>
                    <?php if ($enableFilling): ?>
                        <!-- Check for the day -->
                        <td class="SH_checkCase text-center" value="1">
                            <?php if (count($action["checksDay"]) == 0): ?>
                                <button class="btn btn-primary checkShiftBtn">Valider</button>
                                <button class="btn btn-secondary mt-2 ignoreShiftBtn">Ignorer</button>
                            <?php else: ?>
                                <?php foreach ($action["checksDay"] as $check): ?>
                                    <button class="btn <?= $check['value'] ? 'btn-success' : 'btn-light btn-sm text-muted' ?> unCheckShiftBtn">
                                        <?= $check["initials"] ?>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        <!-- Check for the night -->
                        <td class="SH_checkCase" value="0">
                            <?php if (count($action["checksNight"]) == 0): ?>
                                <button class="btn btn-primary checkShiftBtn">Valider</button>
                                <button class="btn btn-secondary mt-2 ignoreShiftBtn">Ignorer</button>
                            <?php else: ?>
                                <?php foreach ($action["checksNight"] as $check): ?>
                                    <button class="btn <?= $check['value'] ? 'btn-success' : 'btn-light btn-sm text-muted' ?> unCheckShiftBtn">
                                        <?= $check["initials"] ?>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                        <!-- Comments for the action -->
                        <td class="SH_comment">
                            <div id="commentList<?= $action['id'] ?>">
                                <?php foreach ($action["comments"] as $comment): ?>
                                    <div class="<?= ($comment['carryOn'] == 1 and $comment['endOfCarryOn'] == null) ? 'carry' : 'notCarry' ?>"
                                         id="comment-<?= $comment['id'] ?>">
                                        <!-- title -->
                                        <div style="height: 35px">
                                            <button class="removeCarryOnBtn carried" value=<?= $comment['id'] ?>>
                                                <i class="fas fa-thumbtack fa-lg" style="color:#000000"></i>
                                            </button>
                                            <button class="addCarryOnBtn addCarry" value=<?= $comment['id'] ?>>
                                                <i class="fas fa-thumbtack fa-rotate-90 fa-lg"
                                                   style="color:#777777"></i>
                                            </button>
                                            <strong>[ <?= $comment['initials'] ?>
                                                - <?= date('H:i', strtotime($comment['time'])) ?> <?= ($comment['carryOn'] == 1) ? date('/  d.m.Y ', strtotime($comment['time'])) : "" ?>
                                                ] :</strong>
                                        </div>

                                        <!-- Comment -->
                                        <?= $comment['message'] ?>
                                        <hr>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="btn blueBtn btn-block m-1 d-print-none addShiftCommentBtn">Nouveau
                                commentaire
                            </button>
                        </td>
                    <?php else: ?>
                        <td <?= ($shiftsheet['status'] == 'close' and count($action["checksDay"]) == 0) ? 'class="incompleteTask"' : '' ?> >
                            <?php foreach ($action["checksDay"] as $check): ?>
                                <?= $check["initials"] ?>
                            <?php endforeach; ?>
                        </td>
                        <td <?= ($shiftsheet['status'] == 'close' and count($action["checksNight"]) == 0) ? 'class="incompleteTask"' : '' ?> >
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
            <?php if ($enableStructureChange): ?>
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
    <?php if ($_SESSION['user']['admin']): ?>
        <div class="float-right d-print-none">
            <div class="d-flex flex-row">
                <?php if ($model["suggested"] == 0) : ?>
                    <?php if ($model["name"] != "") : ?>
                        <button class="btn blueBtn m-1"
                                onclick="reAddShiftModel(<?= $shiftsheet["model"] ?>, '<?= $model["name"] ?>',<?= $shiftsheet['id'] ?>)">
                            Ré-activer le modèle
                        </button>
                    <?php else : ?>
                        <button class="btn blueBtn m-1"
                                onclick="saveShiftModel(<?= $shiftsheet['id'] ?>,<?= $shiftsheet["model"] ?>)">
                            Enregistrer comme modèle
                        </button>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if ($model["name"] != "Vide") : ?>
                        <button class="btn blueBtn m-1"
                                onclick='disableShiftModel(<?= $shiftsheet["model"] ?>, "<?= $model["name"] ?>",<?= $shiftsheet['id'] ?>)'>
                            Oublier le modèle
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<script src="js/shift.js"></script>
<?php
$content = ob_get_clean();
require GABARIT;
?>
