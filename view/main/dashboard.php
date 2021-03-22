<?php
/**
 * Title: CSUNVB
 * USER: michael gogniat
 * DATE: 22.03.2021
 **/
ob_start();
$title = "CSU-NVB - Accueil";
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h3>Gardes</h3>
            <div style="width: 100%;height: 80px;border-radius: 5px;margin: 20px 0 20px 0;" class="slugOpen">

            </div>
            <div style="width: 100%;height: 80px;border-radius: 5px;margin: 20px 0 20px 0;" class="slugBlank">

            </div>
            <div style="width: 100%;height: 80px;border-radius: 5px;margin: 20px 0 20px 0;" class="slugReopen">

            </div>
        </div>
        <div class="col">
            <h3>Tâches</h3>
            <div style="width: 100%;height: 80px;border-radius: 5px;margin: 20px 0 20px 0;" class="slugOpen">

            </div>
            <h3>Stupéfiants</h3>
            <div style="width: 100%;height: 80px;border-radius: 5px;margin: 20px 0 20px 0;" class="slugOpen">

            </div>
        </div>
    </div>


<?php
$content = ob_get_clean();
require GABARIT;
?>
