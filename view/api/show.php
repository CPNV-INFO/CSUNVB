<?php

if(isset($httpErrorCode)){
    http_response_code($httpErrorCode);
    return;
}

if(isset($outText)){
    echo $outText;
}else{
    http_response_code(500);
}
