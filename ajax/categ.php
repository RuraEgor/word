<?php
require_once '../config.php';

$_POST['choice'] = (isset($_POST['choice'])) ? $_POST['choice'] : '&&&';

if ($_POST['choice'] != '&&&') {

    $per = mysql_query(" SELECT * FROM `$tbLink` WHERE `group_id` = '" . $_POST['choice'] . "' ORDER BY `number` ");

    $mes = array();

    while ($row = mysql_fetch_assoc($per)) {
        $mes[] = $row;
    }

    header('Content-Type: application/json');
    print json_encode($mes);
}

//--------------------------------------------------------------------------------

$_POST['list'] = (isset($_POST['list'])) ? $_POST['list'] : '&&&';
$list = $_POST['list'];

if ($list != "&&&") {

    $per = mysql_query(" SELECT * FROM `$tbCat` ORDER BY `number` ASC ");

    $mes = array();

    while ($row = mysql_fetch_assoc($per)) {
        $mes[] = $row;
    }

    header('Content-Type: application/json');
    print json_encode($mes);
}

//--------------------------------------------------------------------------------

$_POST['gr'] = (isset($_POST['gr'])) ? $_POST['gr'] : '&&&';

if ($_POST['gr'] != '&&&') {

    $per = mysql_query(" SELECT * FROM `$tbLink` WHERE `group_id` = '" . $_POST['gr'] . "' ORDER BY `number` ");

    $mes = array();

    while ($row = mysql_fetch_assoc($per)) {
        $mes[] = $row;
    }

    header('Content-Type: application/json');
    print json_encode($mes);
}