<?php
require_once '../config.php';

$_POST['vodca'] = (isset($_POST['vodca'])) ? $_POST['vodca'] : '&&&';

if ($_POST['vodca'] == 'yes') {

    $mes = array();
    $per = mysql_query(" SELECT `name`,`view`,`id`,`date`,`timeCreat` FROM `$tbCat` ORDER BY `number` ASC ");

    while ($row = mysql_fetch_assoc($per)) {
        $mes['name'][] = $row['name'];
        $mes['view'][] = $row['view'];
        $mes['id'][] = $row['id'];
        $mes['date'][] = $row['date'];
        $mes['timeCreat'][] = $row['timeCreat'];
    }

    header('Content-Type: application/json');
    print json_encode($mes);
}


//------------  СОЗДАНИЕ НОВОЙ КАТЕГОРИИ  ---------
$_POST['name'] = (isset($_POST['name'])) ? $_POST['name'] : '&&&';
$_POST['background'] = (isset($_POST['background'])) ? $_POST['background'] : '&&&';
$_POST['context'] = (isset($_POST['context'])) ? $_POST['context'] : '&&&';
$_POST['img'] = (isset($_POST['img'])) ? $_POST['img'] : '&&&';
$_POST['backgorundImg'] = (isset($_POST['backgorundImg'])) ? $_POST['backgorundImg'] : '';
$_POST['view'] = (isset($_POST['view'])) ? $_POST['view'] : '&&&';

$now = (string)(date("Y-d-m H:i:s"));
$timeCreat = time();

$mesCreateDir;

if (isset($_POST['background'])) {
    if ($_POST['background'] == '#000000') {
        $_POST['background'] = '#74AAF6';
    }
} else {
    $_POST['background'] = '#74AAF6';
}

if ($_POST['name'] != '&&&') {

    $root = false;
    $mesCreate = false;

    $per = mysql_query(" SELECT `name` FROM `$tbCat` ORDER BY `id` ");

    while ($row = mysql_fetch_assoc($per)) {
        if ($row['name'] == $_POST['name']) {
            $root = true;
        }
    }

    if (!$root) {
        $myq = "INSERT INTO `$tbCat` (
                                      `name`,
                                      `background`,
                                      `context`,
                                      `img`,
                                      `view`,
                                      `date`,
                                      `timeCreat`
                                      )
                                       VALUES
                                      (
                                       '" . $_POST['name'] . "',
                                       '" . $_POST['background'] . "',
                                       '" . $_POST['context'] . "',
                                       '" . $_POST['backgorundImg'] . "',
                                       '" . $_POST['view'] . "',
                                       '" . $now . "',
                                       '" . $timeCreat . "'
                                       )";

        $prov = mysql_query($myq);

        $id_link = mysql_insert_id();  //--  ОПРЕДЕЛЕНИЕ "ID" ПОСЛЕДНЕГО СОЗДАННОГО ЭЛЕМЕНТА

        //--  ОПРЕДЕЛЕНИЕ ОБЩЕГО КОЛИЧЕСТВА КАТЕГОРИЙ
        $pes = mysql_query(" SELECT COUNT(`id`) FROM `$tbCat` ");
        $row = mysql_fetch_row($pes);
        $count = $row[0];

        //-- ВСТАВКА НОМЕРА ССЫЛКИ В ГРУППЕ
        mysql_query(" UPDATE `$tbCat` SET `number` = '" . $count . "' WHERE `id` = '" . $id_link . "' ");

        if ($prov) {
            $per = mysql_query(" SELECT * FROM `$tbCat` WHERE id='" . $id_link . "' ");
            while ($row = mysql_fetch_assoc($per)) {
                $mesCreateDir = $row;
            }
        }

    }

    header('Content-Type: application/json');
    print json_encode($mesCreateDir);
}
//===========


//------  УДАЛЕНИЕ КАТЕГОРИИ  ---------
$nameDelCat = (isset($_POST['nameDelCat'])) ? $_POST['nameDelCat'] : '&&&';

if ($nameDelCat != '&&&') {

    $nomEl = array();

    //------  ОПРЕЛЕЛЕНИЕ ИМЕНИ КАТЕГОРИИ  ---------
    $nomElem = mysql_query(" SELECT `id`,`name`,`kol`,`number` FROM `$tbCat` WHERE `id` = '" . $nameDelCat . "' ");
    $paramGr = mysql_fetch_row($nomElem);


    //------  УДАЛЕНИЕ ВСЕХ ССЫЛОК СВЯЗАННЫХ С КАТЕГОРИЕЙ
    $provLin = mysql_query(" DELETE FROM `$tbLink` WHERE ( `group_id` = '" . $paramGr[0] . "' ) ");

    //------  УДАЛЕНИЕ САМОЙ КАТЕГОРИИ  ---------
    $provLin = mysql_query(" DELETE FROM `$tbCat` WHERE `id` = '" . $nameDelCat . "' ");


    //-- БЛОК ОПРЕДЕЛЕНИЯ КОЛИЧ. КАТЕГОРИЙ
    $pes = mysql_query(" SELECT COUNT(`id`) FROM `$tbCat` ");
    $row = mysql_fetch_row($pes);
    $count = $row[0];


    //------ ФОРМИРОВАНИЕ НОВОГО ПОРЯДКА НОМЕРОВ КАТЕГОРИЙ  ---------
    for ($i = $paramGr[2]; $i < ($count + 1); $i++) {
        $x = $i + 1;
        mysql_query(" UPDATE `$tbCat` SET `number`='" . $i . "' WHERE `number` = '" . $x . "' ");
    }

    if ($provLin) {
        header('Content-Type: application/json; charset=utf-8');
        print json_encode('4');
    }
}
//=======


//------  ОБНОВЛЕНИЕ КАТЕГОРИИ  ---------
$UPDATE_GROUP = (isset($_POST['UPDATE_GROUP'])) ? $_POST['UPDATE_GROUP'] : '&&&&';

$mes = array();

if ($UPDATE_GROUP != '&&&&') {

    $per = mysql_query(" SELECT * FROM `$tbCat` WHERE `id` = $UPDATE_GROUP ");

    while ($row = mysql_fetch_assoc($per)) {
        $mes[0] = $row["id"];
        $mes[1] = $row["name"];
        $mes[2] = $row["background"];
        $mes[3] = $row["context"];
        $mes[4] = $row["data"];
        $mes[5] = $row["img"];
        $mes[6] = $row["view"];
    }

    header('Content-Type: application/json; charset=utf-8');
    print json_encode($mes);
}


//=====  UPDATE DIRECTORIES
$UPD_GR_F = (isset($_POST['UPDATE_GROUP_FULL'])) ? $_POST['UPDATE_GROUP_FULL'] : '&&&&';

$mes = array();

$povt_cat = false;
$idSameName = false;
$nameCat = '';


if ($UPD_GR_F != '&&&&') {

    $per = mysql_query(" SELECT `name` FROM `$tbCat` WHERE `id` = '" . $UPD_GR_F[0] . "' ");

    //=====  IF NAME DIRECTORY SAME
    while ($row = mysql_fetch_assoc($per)) {

        $nameCat = $row["name"];

        if ($UPD_GR_F[1] == $row["name"]) {
            $povt_cat = true;

            $apdate = mysql_query(" UPDATE `$tbCat` SET `background` = '" . $UPD_GR_F[2] . "',
                                                        `context` = '" . $UPD_GR_F[3] . "',
                                                        `view` = '" . $UPD_GR_F[4] . "',
                                                        `img` = '" . $UPD_GR_F[5] . "'
                                                    WHERE id = '" . $UPD_GR_F[0] . "' ");
        }

        $mes[0] = 1;  //=====  if only update
    }


    //=====  IF NAME DIRECTORY DIFFERENT
    if (!$povt_cat) {

        $per = mysql_query(" SELECT `name` FROM `$tbCat` ");

        while ($row = mysql_fetch_assoc($per)) {

            if ($UPD_GR_F[1] == $row["name"]) {
                $idSameName = true;
                break;
            }
        }


        //=====  IF NAME DIRECTORY DIFFERENT
        if ($idSameName) {

            $mes[0] = 0; //=====  if name already is

        } else {

            //--  UPDATE DIRECTORY
            $apdate = mysql_query(" UPDATE `$tbCat` SET `name` = '" . $UPD_GR_F[1] . "',
                                                        `background` = '" . $UPD_GR_F[2] . "',
                                                        `context` = '" . $UPD_GR_F[3] . "',
                                                        `view` = '" . $UPD_GR_F[4] . "',
                                                        `img` = '" . $UPD_GR_F[5] . "'
                                                    WHERE id = '" . $UPD_GR_F[0] . "' ");

            //------------

            if ($apdate) {
                $apdate = mysql_query(" UPDATE `$tbLink` SET `group` = '" . $UPD_GR_F[1] . "'  WHERE `group_id` = '" . $UPD_GR_F[0] . "' ");
            }

            $mes[0] = 2; //=====  if update name
            $mes[1] = $UPD_GR_F[1];
            $mes[2] = $nameCat;
        }
    }

    header('Content-Type: application/json; charset=utf-8');
    print json_encode($mes);
}

//------  КОНЕЦ ОБНОВЛЕНИЕ КАТЕГОРИИ  ------------