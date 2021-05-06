<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 **/

ob_start();
$title = "CSU-NVB - Administration - Nova";
?>
<form action="" method="POST">
    <input type="month"  name="date" value="<?=$date?>" onchange="this.form.submit()">
</form>


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
                        <?= $day["number"] ?>
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
