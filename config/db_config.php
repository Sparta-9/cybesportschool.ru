<?php

$C = array();

$C['DB_HOST'] = 'localhost';

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

    $C['DB_USER']='root';
    $C['DB_PASS']='root';

} else {

    $C['DB_USER']='root';
    $C['DB_PASS']='root';

}

$C['DB_NAME']='shumkov';
?>