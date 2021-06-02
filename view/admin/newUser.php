<?php
/**
 * Auteur: Thomas Grossmann / Mounir Fiaux
 * Date: Mars 2020
 **/

ob_start();
$title = "CSU-NVB - Administration - Nouveau secouriste";
?>
<form method="post" action="?action=saveNewUser">
    <table class="table table-bordered">
        <thead>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Initiales</th>
        <th>Mot de passe de départ</th>
        </thead>
        <tbody>
        <tr>
            <td><input type="text" name="prenomUser" required></td>
            <td><input type="text" name="nomUser" required></td>
            <td><input type="text" name="initialesUser" required></td>
            <td><input type="password" name="startPassword" required></td>
        </tr>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Créer</button>
</form>

<div>
    <form>
        <input type="hidden" name="action" value="adminCrew">
        <button type="submit" class="btn blueBtn m-1 float-right">Retour à la liste</button>
    </form>
</div>

<div class="sheetForm" style="width: 400px !important;">
    <h3 class="mr-3 d-inline">Ajouter un secouriste</h3>
    <form method="post" action="?action=saveNewUserT">
        <table>
            <tr>
                <td>
                    <label for="username">Prénom *</label><br>
                    <input name="firstname" type="text" required autocomplete="off">
                </td>
                <td>
                    <label for="username">Nom *</label><br>
                    <input name="lastname" type="text" required autocomplete="off">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="username">Initiales *</label><br>
                    <input name="initials" type="text" required autocomplete="off">
                </td>
                <td>
                    <label for="username">Téléphone</label><br>
                    <input name="tel" type="text" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="username">Email *</label><br>
                    <input name="email" type="email" style="width: 100%" required autocomplete="off">
                </td>
            </tr>
        </table>
        <button type="submit" class="btn blueBtn">Créer</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require GABARIT;
?>
