<?php
require_once '../config.php';

$_POST['name'] = (isset($_POST['name'])) ? $_POST['name'] : '&&&';

if ($_POST['name'] != '&&&') {

    $nameDel = $_POST['name'];
    $nomEl = array();

    //------  ОПРЕЛЕЛЕНИЕ НОМЕРА ЭЛЕМЕНТА  ---------
    $pes = mysql_query(" SELECT `number`,`group_id` FROM `$tbLink` WHERE `id` = '" . $nameDel . "' ");

    while ($row = mysql_fetch_assoc($pes)) {
        $nomEl[0] = $row['number'];    //-- номер удаляемой ссылки
        $nomEl[1] = $row['group_id'];  //-- группа удаляемой ссылки
    }

    //------  УДАЛЕНИЕ НУЖНОГО ЭЛЕМЕНТА  ----------
    $prov = mysql_query(" DELETE FROM `$tbLink` WHERE ( `id` = '" . $nameDel . "' ) ");

//    //------  ПРОВЕРКА СУЩЕСТВОВАНИЯ УДАЛЁННОГО ЭЛЕМЕНТА  ----------
//    if ($prov) {
//        $mes[0] = "Ссылка \"" . $_POST['name'] . "\" не была удалена!";
//        $mes[1] = 2;
//    }

    //-- БЛОК ОПРЕДЕЛЕНИЯ КОЛИЧ. ССЫЛОК В КАТЕГОРИИ
    $pes = mysql_query(" SELECT COUNT(*) FROM `$tbLink` WHERE `group_id` = '" . $nomEl[1] . "' ");
    $row = mysql_fetch_row($pes);
    $count = $row[0];
    mysql_query(" UPDATE `$tbCat` SET `kol` = '" . $count . "' WHERE `name` = '" . $nomEl[1] . "' ");


    //------ ФОРМИРОВАНИЕ НОВОГО ПОРЯДКА НОМЕРОВ  ---------
    for ($i = $nomEl[0]; $i < ($count + 1); $i++) {
        $x = $i + 1;
        mysql_query(" UPDATE `$tbLink` SET `number`='" . $i . "' WHERE `group_id` = '" . $nomEl[1] . "' AND `number` = '" . $x . "' ");
    }


    if ($prov) {
        header('Content-Type: application/json;charset=utf-8');
        print json_encode($nomEl);
    }

}

//-------