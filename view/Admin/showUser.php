<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 **/
ob_start();
$title = "CSU-NVB - Administration - Planning";
?>
<h1><?= $user["firstname"] ?> <?= $user["lastname"] ?></h1>
<div>
    <form>
        <input type="hidden" name="action" value="adminCrew">
        <button type="submit" class="btn blueBtn m-1 float-right">Retour à la liste</button>
    </form>
</div>
<div style="margin-top: 40px;margin-bottom: 20px" class="d-flex">
    <form action="?action=showUser&id=<?= $user["id"] ?>" method="POST">
        <input type="hidden" name="month" value="<?= ($selectedMonth == 1) ? "12" : $selectedMonth - 1 ?>">
        <input type="hidden" name="year" value="<?= ($selectedMonth == 1) ? $selectedYear - 1 : $selectedYear ?>">
        <button type="submit" style="background-color: white;"><i class="fas fa-chevron-left"></i></button>
    </form>
    <form action="?action=showUser&id=<?= $user["id"] ?>" method="POST">
        <input type="hidden" name="month" value="<?= ($selectedMonth == 12) ? "1" : $selectedMonth + 1 ?>">
        <input type="hidden" name="year" value="<?= ($selectedMonth == 12) ? $selectedYear + 1 : $selectedYear ?>">
        <button type="submit" style="background-color: white;"><i class="fas fa-chevron-right"></i></i></button>
    </form>
    <h4 style="margin-left: 5px"> <?= $monthNames[$selectedMonth - 1] . " " . $selectedYear ?></h4>
</div>
<table class="calender">
    <?php foreach ($calendar as $week): ?>
        <tr>
            <?php foreach ($week as $day): ?>
                <td class="col">
                    <div style="background-color: <?= $day['color'] ?>; " class="day">
                        <div class="dayName">
                            <?= date_format($day["date"], "j") ?>
                        </div>
                        <div style="font-size: 12px;margin-top: 7px;">
                            <?php foreach ($day["works"] as $work): ?>
                                <strong><?= $work["type"] ?> <?= $work["base"] ?> </strong>
                                <?php if (isset($work["day"])) : ?>
                                    <?php if ($work["day"] === 1 ) : ?>
                                        <i class="fas fa-sun fa-lg"></i>
                                    <?php else : ?>
                                        <i class="fas fa-moon fa-lg"></i>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
<script src="js/admin.js" defer></script>
<?php
$content = ob_get_clean();
require GABARIT;
?>
