<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 **/
ob_start();
$title = "CSU-NVB - Administration - Secouristes";
?>
<a href="?action=newUser" class="btn btn-success">Créer un utilisateur</a>

<form action="?action=importPlanning" method="post" class="d-inline float-right" accept-charset="utf-8" enctype="multipart/form-data">
    <input type="file" name="file" id="selectedFile" accept=".csv" class="d-none">
    <button class="btn blueBtn" id="submitFileBtn" onclick="document.getElementById('selectedFile').click()">
        Planning <i class="fas fa-file-upload"></i>
    </button>
</form>

<table class="table table-bordered table-hover" style="text-align: center">
    <thead class="thead-dark">
    <th>Initiales</th>
    <th>Prénom</th>
    <th>Nom</th>
    <th>Mail</th>
    <th>Téléphone</th>
    <th>Rôle</th>
    <!--<th>Statut</th>-->
    </thead>
    <tbody>
    <?php foreach ($users as $user) { ?>
        <tr id="user-<?= $user['id'] ?>">
        <td style="width: 110px">
            <div style="margin: 0 !important;" class="row">
                <div style="margin-top: 5px">
                    <?= $user['initials'] ?>
                </div>
                <div style="margin-left: 12px;">
                    <a href="?action=showUser&id=<?= $user['id'] ?>" class="text-dark">
                        <i class="far fa-calendar-alt fa-2x modify"></i>
                    </a>
                </div>
            </div>

        </td>
        <td><?= $user['firstname'] ?></td>
        <td><?= $user['lastname'] ?></td>
        <td>
            <div class="displayMail">
                <div class="mail"><?= $user['email'] ?></div>
                <i class="fas fa-pen modify" onclick="mailForm(<?= $user['id'] ?>)"></i>
            </div>
            <div class="updateMail">
                <input type="email" class="inputMail"><i class="fas fa-check saveIcon" onclick="mailUpdate(<?= $user['id'] ?>)"></i><i class="fas fa-times cancelIcon" onclick="resetMail(<?= $user['id'] ?>)"></i>
            </div>

        </td>
        <td>
            <div class="displayTel">
                <div class="tel"><?= $user['mobileNumber'] ?></div>
                <i class="fas fa-pen modify" onclick="telForm(<?= $user['id'] ?>)"></i>
            </div>
            <div class="updateTel">
                <input type="text" class="inputTel"><i class="fas fa-check saveIcon" onclick="telUpdate(<?= $user['id'] ?>)"></i><i class="fas fa-times cancelIcon" onclick="resetTel(<?= $user['id'] ?>)"></i>
            </div>
        </td>
        <td><?php
            if ($user['id'] != $_SESSION['user']['id']) { if ($user['admin'] == 1) { ?>
        <a href="?action=changeUserAdmin&idUser=<?= $user['id'] ?>" class="btn btn-primary">Changer en utilisateur</a><?php } else { ?>
        <a href="?action=changeUserAdmin&idUser=<?= $user['id'] ?>" class="btn btn-primary">Changer en administrateur</a><?php } } else { ?>
        <p>Vous ne pouvez pas changer votre propre état</p><?php } ?>
            <!--<td><?php if ($user['firstconnect'] == 1) { ?>Mot de passe expiré<br><?php } ?> <a href="?action=resetUserPassword&idUser=<?= $user['id'] ?>" class="btn btn-primary">Réinitialiser le mot de passe</a></td>-->
        </tr><?php } ?>
    </tbody>
</table>

<script src="js/admin.js" defer></script>
<?php
$content = ob_get_clean();
require GABARIT;
?>
