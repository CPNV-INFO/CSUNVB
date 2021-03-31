<?php
$page = getPage($_GET["action"]);
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>
        <?= (isset($title)) ? $title : "Page sans nom" ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/@fortawesome/fontawesome-free/css/all.css" rel="stylesheet">

    <script src="assets/jquery/dist/jquery.js"></script>
    <script src="assets/bootstrap/dist/js/bootstrap.bundle.js"></script>

    <link href="css/main.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">

    <script src="js/main.js" defer></script>
    <script src="js/global.js" defer></script>
    <script src="js/modal.js" defer></script>
    <?php
    switch ($page) {
        case "shift":
            echo '<link href="css/shift.css" rel="stylesheet"><script src="js/shiftt.js" defer></script>';
            break;
        case "todo":
            echo '<link href="css/todo.css" rel="stylesheet"><script src="js/todo.js" defer></script>';
            break;
        case "drug":
            echo '<link href="css/drug.css" rel="stylesheet"><script src="js/drug.js" defer></script>';
            break;
        case "admin":
            echo '<link href="css/admin.css" rel="stylesheet"><script src="js/admin.js" defer></script>';
            break;
        default:
    }
    ?>
</head>

<body>
<div class="d-print-none banner">
    <header>
        <div class="container">
            <div class="row">
                <a href="?action=home" class="col-auto">
                    <img class="logo m-3 justify-content-center" src="assets/images/logo.png">
                </a>
                <div class="title col mt-4">
                    Gestion des rapports
                    <?= gitBranchTag() ?>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['user'])) : ?>
            <div class="container navZone">
                <nav class="navbar navbar-expand-sm bg-dark navbar-dark rounded">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item <?= ($page == "dashboard") ? 'active' : '' ?>">
                            <a class="nav-link" href="?action=home">Accueil</a>
                        </li>
                        <li class="nav-item <?= ($page == "shift") ? 'active' : '' ?>">
                            <a class="nav-link" href="?action=shiftList">Gardes</a>
                        </li>
                        <li class="nav-item <?= ($page == "todo") ? 'active' : '' ?>">
                            <a class="nav-link" href="?action=listtodo">Tâches</a>
                        </li>
                        <li class="nav-item <?= ($page == "stup") ? 'active' : '' ?>">
                            <a class="nav-link" href="?action=listDrugSheets">Stupéfiants</a>
                        </li>
                        <?php if ($_SESSION["user"]["admin"] == 1): ?>
                            <li class="nav-item <?= ($page == "admin") ? 'active' : '' ?>">
                                <a class="nav-link" href="?action=adminHome">Administration</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <?php if (isset($_SESSION['user'])) : ?>
                        <div style="display: flex;align-items: center" class="navbar-nav">
                            <a href="?action=disconnect" class="nav-item nav-link">
                                <i class="fas fa-sign-out-alt fa-lg"></i>
                                <div class="d-inline"><?= $_SESSION['user']['initials'] ?>@<?= $_SESSION['base']['name']?></div>
                            </a>
                        </div>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </header>
</div>


<div class="container mainContent">
    <div id="flashMessage">
        <?= getFlashMessage() ?>
    </div>
    <?= (isset($content)) ? $content : "page vide" ?>
    <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post" id="mainModalForm" action="">
                    <div class="modal-header">
                        <h5 id="mainModalTitle">
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="mainModalBody">
                    </div>
                    <div class="modal-footer">
                        <div id="mainModalCancel">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        </div>
                        <div id="mainModalSubmit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
