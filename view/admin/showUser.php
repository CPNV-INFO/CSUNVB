<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 **/
ob_start();
$title = "CSU-NVB - Administration - Planning";
?>
<div>
    <form>
        <input type="hidden" name="action" value="adminCrew">
        <button type="submit" class="btn blueBtn m-1 float-right">Retour à la liste</button>
    </form>
</div>
<h1>Profil de <?= $user["firstname"] ?> <?= $user["lastname"] ?></h1>
<form action="?action=updateUser" method="POST">
    <input type="hidden" name="idUser" value="<?= $user["id"] ?>">
    <div class="form-row">
        <div class="col-form-label col-2">Prénom</div>
        <input type="text" name="fname" class="form-control col-4" style="text-transform: capitalize;" required value="<?= $user["firstname"] ?>" />
    </div>
    <div class="form-row">
        <div class="col-form-label col-2">Nom</div>
        <input type="text" name="lname" class="form-control col-4" style="text-transform: capitalize;" required value="<?= $user["lastname"] ?>"/>
    </div>
    <div class="form-row">
        <div class="col-form-label col-2">Initiales</div>
        <input type="text" name="initials" style="text-transform: uppercase;" minlength="3" maxlength="3" class="form-control col-1" value="<?= $user["initials"] ?>"/>
    </div>
    <button type="submit" class="btn btn-primary m-1">Enregistrer</button>
    <a class="btn btn-secondary m-1" href="?action=adminCrew">Annuler</a>
</form>
<hr>
<h3>Horaire</h3>
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
                                    <?php if ($work["day"] == 1 ) : ?>
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
