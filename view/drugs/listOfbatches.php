<?php
ob_start();
$title = "CSU-NVB - Liste de lots de stupéfiants";
?>

<div>
    <h1>Lots de stupéfiants</h1>
    <h2>Base de <?= $_SESSION['base']['name'] ?> </h2>
</div>

<table id="batachListTable" border="1" class="table table-bordered w-50">
    <thead class="thead-dark">
    <tr>
        <th>Lot</th>
        <th>état</th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($drugs as $drug): ?>
        <tr>
            <td colspan="2" class="font-weight-bold"><?= $drug["name"] ?></td>


        </tr>
        <?php foreach ($batchesByDrugId[$drug["id"]] as $batch): ?>
            <tr>
                <td class="text-right">
                    <?= $batch['number'] ?>
                </td>
                <td class="text-center">
                    <? switch ($batch['state']){
                        case 'new':
                            echo 'neuf';
                            break;
                        case 'inuse':
                            echo 'Enntamé';
                            break;
                        case 'used':
                            echo 'utilisé';
                            break;
                        default:
                            echo $batch['state'];
                    }

                    ?>
                </td>


            </tr>

        <?php endforeach; ?>
        <tr>
            <td colspan="2">
            <button type='button' class='btn btn-primary m-1'>Ajouter un lot</button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
require GABARIT;
?>
