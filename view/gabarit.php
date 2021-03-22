<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>
        <?= (isset($title)) ? $title : "Page sans nom" ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- paths are from root ( where there is index.php ) -->
    <link href="assets/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/shift.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/@fortawesome/fontawesome-free/css/all.css" rel="stylesheet">



    <script src="assets/jquery/dist/jquery.js"></script>
    <script src="assets/bootstrap/dist/js/bootstrap.js"></script>
    <script src="js/global.js" defer></script>
    <script src="js/modal.js" defer></script>
</head>
<body>
<div class="d-print-none banner">
    <header>
        <div class="row">
            <a href="?action=home" class="col-auto">
                <img class="logo m-3 justify-content-center" src="assets/images/logo.png">
            </a>
            <div class="title col mt-4">
                Gestion des rapports
                <?= gitBranchTag() ?>
            </div>
            <?php if (isset($_SESSION['user'])) : ?>
                <a href="?action=disconnect" class="btn btn-primary mt-2 mr-5 float-right"><div class="font-weight-bold m-2">Déconnecter</div><div class="small"><?= $_SESSION['user']['initials'] ?>@<?= $_SESSION['base']['name'] ?></div></a>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['user'])) : ?>
            <div class="container navZone">
                <nav class="navbar navbar-expand-sm bg-dark navbar-dark rounded">
                    <ul class="navbar-nav">
                        <?php require "../pageList.php"; ?>
                        <li class="nav-item <?= (in_array($_GET["action"], $dashboardPages)) ? 'active' : '' ?>">
                            <a class="nav-link" href="?action=home">Dashboard</a>
                        </li>
                        <li class="nav-item <?= (in_array($_GET["action"], $shiftPages)) ? 'active' : '' ?>">
                            <a class="nav-link" href="?action=shiftList">Gardes</a>
                        </li>
                        <li class="nav-item <?= (in_array($_GET["action"], $todoPages)) ? 'active' : '' ?>">
                            <a class="nav-link" href="?action=listtodo">Tâches</a>
                        </li>
                        <li class="nav-item <?= (in_array($_GET["action"], $stupPages)) ? 'active' : '' ?>">
                            <a class="nav-link" href="?action=listDrugSheets">Stupéfiants</a>
                        </li>
                        <?php if($_SESSION["user"]["admin"] ==1 ):?>
                            <li class="nav-item <?= (in_array($_GET["action"], $adminPages)) ? 'active' : '' ?>">
                                <a class="nav-link" href="?action=adminHome">Administration</a>
                            </li>
                        <?php endif;?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </header>
</div>

<div class="container p-4" >
    <div id="flashMessage">
        <?= getFlashMessage() ?>
    </div>
    <?= (isset($content)) ? $content : "page vide" ?>
    <div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
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
