<?php


function basesList()
{
    $outText = json_encode(getbases());
    require_once '../../view/api/show.php';
}

function notFound()
{
    $httpErrorCode = '404';
    require_once '../../view/api/show.php';
}