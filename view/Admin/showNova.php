<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 **/

ob_start();
$title = "CSU-NVB - Administration - Nova";
?>
<input type="hidden" id="novaID" value="<?= $nova["id"] ?>"><!-- used to get id in javascrpt -->
<h1>Nova <?= $nova["number"] ?></h1>
<div>
    <form>
        <input type="hidden" name="action" value="adminNovas">
        <button type="submit" class="btn blueBtn m-1 float-right">Retour à la liste</button>
    </form>
</div>
<div>
    <form action="?action=updateNova&id=<?= $nova["id"] ?>" method="POST">
        <div>Modifier le numéro :</div>
        <input type="number" name="updateNumberNova" required
               style="width: 100px;padding: 0.375rem 0.75rem;border: 1px solid #ced4da;border-radius: 0.25rem"
               value="<?= $nova["number"] ?>">
        <input type="submit" class="btn blueBtn d-inline" value="Modifier">
    </form>
</div>
<div style="margin-top: 40px;margin-bottom: 20px" class="d-flex">
    <form action="?action=showNova&id=<?= $nova["id"] ?>" method="POST">
        <input type="hidden" name="month" value="<?= ($selectedMonth == 1) ? "12" : $selectedMonth - 1 ?>">
        <input type="hidden" name="year" value="<?= ($selectedMonth == 1) ? $selectedYear - 1 : $selectedYear ?>">
        <button type="submit" style="background-color: white;"><i class="fas fa-chevron-left"></i></button>
    </form>
    <form action="?action=showNova&id=<?= $nova["id"] ?>" method="POST">
        <input type="hidden" name="month" value="<?= ($selectedMonth == 12) ? "1" : $selectedMonth + 1 ?>">
        <input type="hidden" name="year" value="<?= ($selectedMonth == 12) ? $selectedYear + 1 : $selectedYear ?>">
        <button type="submit" style="background-color: white;"><i class="fas fa-chevron-right"></i></i></button>
    </form>
    <h4 style="margin-left: 5px"> <?= $monthNames[$selectedMonth - 1] . " " . $selectedYear ?></h4>
</div>

<table class="calender">
    <tr>
        <?php foreach ($dayNames as $dayName): ?>
            <th class="col"><?= $dayName ?></th>
        <?php endforeach; ?>
    </tr>
    <?php foreach ($calendar as $week): ?>
        <tr>
            <?php foreach ($week as $day): ?>
                <td class="col">
                    <div style="background-color: <?= $day['color'] ?>; " class="day">
                        <div class="dayName">
                            <?= date_format($day["date"], "j") ?>
                            <div class="completeDate d-none"><?= date_format($day["date"], "Y-m-d") ?></div>
                            <div style="left: 10px"
                                 class="position-relative <?= ($day["unAvailableDay"] == null) ? 'available' : 'unAvailable' ?>">
                                <div class="position-absolute">
                                    <i class="fas fa-sun"></i>
                                </div>
                                <div class="position-absolute">
                                    <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip"
                                          data-placement="bottom"
                                          title="<?= ($day["unAvailableDay"] == null) ? '' : $day["unAvailableDay"]["initials"] . " " . $day["unAvailableDay"]["comment"] ?>">
                                        <i class="fas fa-slash novaAvailableBtn"></i>
                                    </span>
                                </div>
                            </div>
                            <div style="left: 35px"
                                 class="position-relative <?= ($day["unAvailableNight"] == null) ? 'available' : 'unAvailable' ?>">
                                <div class="position-absolute">
                                    <i class="fas fa-moon"></i>
                                </div>
                                <div class="position-absolute">
                                        <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip"
                                              data-placement="bottom"
                                              title="<?= ($day["unAvailableNight"] == null) ? '' : $day["unAvailableNight"]["initials"] . " " . $day["unAvailableNight"]["comment"] ?>">
                                            <i class="fas fa-slash novaAvailableBtn"></i>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($day["shifts"] as $shift): ?>
                            <div style="font-size: 12px;margin-top: 7px;">
                                Garde <?= $shift["boss"] ?>
                                <br>
                                <?= $shift["base"] ?> <i
                                        class="fas fa-<?= ($shift["day"] == 1) ? 'sun' : 'moon' ?> fa-lg"></i>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
<?php
$content = ob_get_clean();
require GABARIT;
?>
