<?php
require_once '../config.php';

$_POST['apDateId'] = (isset($_POST['apDateId'])) ? $_POST['apDateId'] : '&&&';

if ($_POST['apDateId'] != '&&&') {

    $per = mysql_query(" SELECT * FROM `$tbLink` WHERE `id` = " . $_POST['apDateId'] . " ");
    $mes = array();

    while ($row = mysql_fetch_assoc($per)) {
        $mes = $row;
    }

    header('Content-Type: application/json');
    print json_encode($mes);
}

//---------------------------------------------------------------------------

