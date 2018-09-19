<?php
require_once '../config.php';

$_POST['name'] = (isset($_POST['name'])) ? $_POST['name'] : '&*!';
$_POST['group'] = (isset($_POST['group'])) ? $_POST['group'] : '&*!';
$_POST['links'] = (isset($_POST['links'])) ? $_POST['links'] : '&*!';
$_POST['choise'] = (isset($_POST['choise'])) ? $_POST['choise'] : '&*!';
$_POST['title'] = (isset($_POST['title'])) ? $_POST['title'] : '&*!';

if (isset($_POST['background'])) {
    if ($_POST['background'] == '#000000') {
        $_POST['background'] = '#74AAF6';
    }
} else {
    $_POST['background'] = '#74AAF6';
}


//------  TAKE ICON FROM RECURS -------
function get_favicon($url) {

    $back[0] = 0;

    $back[1] = 1;
    $back[2] = 2;
    $back[3] = 3;

    return $back;
}

$mes = 0;

if ($_POST['links'] != '&*!') {

//------ ПРВОЕРЯЕМ СУЩЕСТВУЕТ ЛИ ССЫЛКА С ТАКИМ ЖЕ ИМЕНЕМ ЧТО И ТА КОТОРУЮ СОБИР. СОЗДАТЬ  ------
    $rew = mysql_query("SELECT `name`,`group_id` FROM `$tbLink`");

    $nalich = 0;

    $nameDw = strtolower($_POST['name']);

    while ($row = mysql_fetch_assoc($rew)) {
        $nameTableDw = strtolower($row['name']);
        if ($nameDw == $nameTableDw && $_POST['group'] == $row['group_id']) {
            $mes = "Ссылка с таким именем и дирректорией уже существует!";
            $nalich = 1;
            break;
        }
    }

    if ($nalich == 0) {

        //------------ ЗАПОМИНАНИЕ ВРЕМЕНИ СОЗДАНИЯ ССЫЛКИ --------------
        $now = (string)(date("Y-d-m H:i:s"));
        $timeCreat = time();


        //=====  GET NAME OF GROUP
        $rew = mysql_query("SELECT `name` FROM `$tbCat` WHERE `id` = '" . $_POST['group'] . "' ");

        while ($row = mysql_fetch_assoc($rew)) {
            $name_group = $row['name'];
        }

        $prav = mysql_query("INSERT INTO `$tbLink` (
                                                    `name`,
                                                    `group_id`,
                                                    `group`,
                                                    `links`,
                                                    `choise`,
                                                    `background`,
                                                    `title`,
                                                    `data`,
                                                    `timeCreat`
                                                    ) VALUES (
                                                    '" . $_POST['name'] . "',
                                                    '" . $_POST['group'] . "',
                                                    '" . $name_group . "',
                                                    '" . $_POST['links'] . "',
                                                    '" . $_POST['choise'] . "',
                                                    '" . $_POST['background'] . "',
                                                    '" . $_POST['title'] . "',
                                                    '" . $now . "',
                                                    '" . $timeCreat . "') ");


        $id_link = mysql_insert_id();  //--  ОПРЕДЕЛЕНИЕ "ID" ПОСЛЕДНЕГО СОЗДАННОГО ЭЛЕМЕНТА

        if ($prav == true) $mes = "Ссылка была создана";

        //=====  COUNT ALL ROWS ONE CATEGORIES
        $pes = mysql_query(" SELECT COUNT(*) FROM `$tbLink` WHERE `group_id` = '" . $_POST['group'] . "' ");
        $row = mysql_fetch_row($pes);
        $count = $row[0];


        //-- ВСТАВКА НОМЕРА ССЫЛКИ В ГРУППЕ
        mysql_query(" UPDATE `$tbLink` SET `number` = '" . $count . "' WHERE `id` = '" . $id_link . "' ");


        //-- ВСТАВКА КОЛИЧ. ССЫЛОК В ГРУППЕ
        mysql_query(" UPDATE `$tbCat` SET `kol` = '" . $count . "' WHERE `id` = '" . $_POST['group'] . "' ");


        $pesr = mysql_query(" SELECT * FROM `$tbLink` WHERE `id` = '" . $id_link . "' ");
        $datas[0] = mysql_fetch_assoc($pesr);


        $datas[1] = $id_link;
        $datas[2] = $_POST['links'];
    }

    if ($nalich == 1) {

        header('Content-Type: application/json; charset=utf-8');
        print json_encode($nalich);
    } else {

        header('Content-Type: application/json; charset=utf-8');
        print json_encode($datas);
    }

}
//----- END ALL DOC ---------
