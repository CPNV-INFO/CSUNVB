<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 **/

ob_start();
$title = "CSU-NVB - Remise de garde";
?>
<script src="js/shiftEnd.js"></script>
<div class="row m-2">
    <h1>Remise de Garde</h1>
</div>

<div class="row">
    <FORM action="?action=listShiftEnd" method="post" class="col">
        <SELECT onchange="this.form.submit()" name="site" size="1">
            <?php foreach ($Bases as $base) { ?>
            <OPTION value="<?= $base['id'] ?>" <?php if ($baseID == $base['id']) { ?>
                selected="selected"
            <?php } ?>
                    name="site"><?= $base['name'] ?>
                <?php } ?>
        </SELECT>
    </FORM>
    <form action="?action=newSheet" method="post">
        <?php if ($admin['admin'] == 1) { ?>
            <div class="col">
                <input type="hidden" name="baseID" value="<?= $baseID ?>">
                <a href="?" class='btn btn-primary m-1 float-right'>Nouvelle Feuille de garde</a>
            </div>
        <?php } ?>
    </form>
</div>
<div class="row m-2">
    <?php
    foreach ($list as $item) {
        if ($item["base_id"] == $_SESSION["Selectsite"]) {
            $weeks[] = $item;

        }
    } ?>
</div>


<table class="table table-bordered  table-striped" style="text-align: center">
    <thead class="thead-dark">
    <th>Date</th>
    <th>État</th>
    <th>Véhicule</th>
    <th>Responsable</th>
    <th>Équipage</th>

    <?php if ($admin['admin'] == 1) { ?>
        <th>Action</th><?php } ?>
    </thead>
    <?php ?>
    <?php foreach ($guardsheets as $guardsheet) { ?>
        <tr>
            <td><a href='?action=showGuardSheet&id=<?= $guardsheet['id'] ?>' class="btn"><?= date('d.m.Y',strtotime($guardsheet['date'])) ?>  </a></td>
            <td><?php if ($guardsheet['state'] == 'open') { ?>
                    <?= "Ouvert " ?>
                <?php }
                if ($guardsheet['state'] == 'reopen') { ?>
                    <?= "Réouverte " ?>
                <?php }
                if ($guardsheet['state'] == 'closed') { ?>
                    <?= "Fermée " ?>
                <?php } ?></td>
            <td>Jour : <?= $guardsheet['novaDay'] ?><br>Nuit : <?= $guardsheet['novaNight'] ?></td>
            <td>Jour :<?= $guardsheet['bossDay'] ?><br>Nuit :<?= $guardsheet['bossNight'] ?> </td>
            <td>Jour : <?= $guardsheet['teammateDay'] ?><br>Nuit : <?= $guardsheet['teammateNight'] ?></td>


            <?php if ($admin['admin'] == 1) { ?>
                <td>
                    <?php if ($guardsheet['state'] == 'closed') : ?>
                        <form action="?action=reOpenShift" method="post">
                            <button class="btn btn-primary btn-sm" name="reOpen" value="<?= $guardsheet['id'] ?>"
                            </button>Reopen
                        </form>
                    <?php endif; ?>
                    <?php if ($guardsheet['state'] == 'open' || $guardsheet['state'] == 'reopen') : ?>
                        <form action="?action=closedShift" method="post">
                            <button class="btn btn-primary btn-sm" name="close" value="<?= $guardsheet['id'] ?>"
                            </button>Close
                        </form>
                    <?php endif; ?>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>

<?php

$content = ob_get_clean();
require GABARIT;
?>
