<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 **/

ob_start();
$title = "CSU-NVB - Administration - Nova";
?>
<h1>Nova <?=$nova["number"]?></h1>
<div>
    <form>
        <input type="hidden" name="action" value="adminNovas">
        <button type="submit" class="btn blueBtn m-1 float-right">Retour à la liste</button>
    </form>
</div>
<div>
    <form action="?action=updateNova&id=<?= $nova["id"] ?>" method="POST">
            <div>Modifier le numéro :</div>
            <input type="number" name="updateNumberNova" required style="width: 100px;padding: 0.375rem 0.75rem;border: 1px solid #ced4da;border-radius: 0.25rem" value="<?=$nova["number"]?>">
            <input type="submit" class="btn blueBtn d-inline" value="Modifier">
    </form>
</div>
<div style="margin-top: 40px;margin-bottom: 20px" class="d-flex">
    <form action="?action=showNova&id=<?= $nova["id"] ?>" method="POST">
        <input type="hidden" name="month" value="<?= ($selectedMonth == 1) ? "12" : $selectedMonth-1 ?>">
        <input type="hidden" name="year" value="<?= ($selectedMonth == 1) ? $selectedYear-1 : $selectedYear ?>">
        <button type="submit"><i class="fas fa-chevron-left"></i></button>
    </form>
    <form action="?action=showNova&id=<?= $nova["id"] ?>" method="POST">
        <input type="hidden" name="month" value="<?= ($selectedMonth == 12) ? "1" : $selectedMonth+1 ?>">
        <input type="hidden" name="year" value="<?= ($selectedMonth == 12) ? $selectedYear+1 : $selectedYear ?>">
        <button type="submit"><i class="fas fa-chevron-right"></i></i></button>
    </form>
    <h4 style="margin-left: 5px"> <?= $monthNames[$selectedMonth-1]." ".$selectedYear ?></h4>
</div>

<table style="width: 100%">
    <tr>
        <?php foreach ($dayNames as $day): ?>
            <th style="width: = 14.2857%"><?= $day ?></th>
        <?php endforeach; ?>
    </tr>
    <?php foreach ($calendar as $week): ?>
        <tr>
            <?php foreach ($week as $day): ?>
                <td style="width: 14.286%;height: 100%" class="taskCol">
                    <div style="min-height: 120px;background-color: <?= ($day['cat'] == "normal") ? 'lightblue' : 'lightgray' ?>; border-radius: 10px;padding: 10px">

                        <div class="row" style="margin: 0 !important; width: 100%">
                            <?= $day["number"] ?>
                            <div style="position: relative;left: 10px;display: none">
                                <div style="position: absolute">
                                    <i class="fas fa-sun" style="background-color: red;padding: 3px; border-radius: 3px"></i>
                                </div>
                                <div style="position: absolute; z-index: 1;left: 1px">
                                    <i class="fas fa-slash"></i>
                                </div>
                            </div>
                            <div style="position: relative;left: 35px;display: none">
                                <div style="position: absolute">
                                    <i class="fas fa-moon" style="background-color: red;padding: 3px; border-radius: 3px"></i>
                                </div>
                                <div style="position: absolute; z-index: 1;left: 1px">
                                    <i class="fas fa-slash"></i>
                                </div>
                            </div>
                        </div>

                        <?php if (rand(0,100)<50) : ?>
                        <div style="font-size: 12px">
                            Garde XCL
                            <br>
                            Ste-Croix Jour
                        </div>
                        <?php endif; ?>
                        <?php if (rand(0,100)<50) : ?>
                            <div style="font-size: 12px">
                                Garde MGT
                                <br>
                                Ste-Croix Nuit
                            </div>
                        <?php endif; ?>
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
