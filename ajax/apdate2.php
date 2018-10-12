<?php
require_once '../config.php';

$apDate = (isset($_POST['apDate'])) ? $_POST['apDate'] : '&&&';

if ($apDate != '&&&') {

    //--  ОБРАБОТКА ТЕКСТОВЫХ ВЕЛИЧИН
    $apDate[1] = $apDate[1];  //--  ПРОСЛЕШОВАНИЕ ИМЕНИ ССЫЛКИ
    $apDate[6] = $apDate[6];  //--  ПРОСЛЕШОВАНИЕ ОПИСАНИЕ ССЫЛКИ

    if ($apDate[4] == '#000000') {
        $apDate[4] = '#74AAF6';
    }

    $flag[0] = 1;  //--  Проверочный флаг

    $per = mysql_query(" SELECT * FROM `$tbLink` WHERE `id` = '" . $apDate[0] . "' ");

    $masDataLink = [];

    while ($row = mysql_fetch_assoc($per)) {
        $masDataLink['id'] = $row["id"];
        $masDataLink['group_id'] = $row["group_id"];
        $masDataLink['group'] = $row["group"];
        $masDataLink['name'] = $row["name"];
        $masDataLink['number'] = $row["number"];
        $masDataLink['background'] = $row["background"];
        $masDataLink['icon'] = $row["icon"];
        $masDataLink['title'] = $row["title"];
        $masDataLink['data'] = $row["data"];
        $masDataLink['timeCreat'] = $row["timeCreat"];
    }


    //----------  ОБНОВЛЕНИЕ ДАННЫХ ЕСЛИ ИМЯ И ГРУППА ОДИНАКОВЫ -------
    if ($masDataLink["name"] == $apDate[1] && $masDataLink["group_id"] == $apDate[2]) {
        $apdate = mysql_query(" UPDATE `$tbLink` SET `background` = '" . $apDate[4] . "',
                                                     `icon` = '" . $apDate[3] . "',
                                                     `title` = '" . $apDate[6] . "'
                                                 WHERE id = " . $apDate[0] . " ");

        $flag[0] = 2;  //=====  change only set
    }


    //----------   ОБНОВЛЕНИЕ ИМЕНИ И ДРУГИХ ПАРАМЕТРОВ ССЫЛКИ ИСКЛЮЧАЯ ГРУППУ -------
    if ($masDataLink["name"] != $apDate[1] && $masDataLink["group_id"] == $apDate[2]) {

        $sameNameLink = false;

        //=====  IF NAME LINK IS
        $per = mysql_query(" SELECT `name` FROM `$tbLink` WHERE `group_id` = " . $apDate[2] . " ");
        while ($row = mysql_fetch_assoc($per)) {
            //-- проверка существ. такой же ссылки в такой же категории
            if ($row["name"] == $apDate[1]) {
                $sameNameLink = true;
                $flag[0] = 6;
                break;
            }
        }

        if (!$sameNameLink) {
            $apdate = mysql_query(" UPDATE `$tbLink` SET `name` = '" . $apDate[1] . "',
                                                         `background` = '" . $apDate[4] . "',
                                                         `icon` = '" . $apDate[3] . "',
                                                         `title` = '" . $apDate[6] . "'
                                                     WHERE id = " . $apDate[0] . " ");

            $flag[0] = $apDate[1];  //=====  change set and name
        }
    }


    //----------   ОБНОВЛЕНИЕ ДАННЫХ ПРИ ИЗМЕНЕНИИ ГРУППЫ  -------
    if ($masDataLink["group_id"] != $apDate[2]) {

        $sameNameLink = false;

        //=====  IF NAME LINK IS
        $per = mysql_query(" SELECT `name` FROM `$tbLink` WHERE `group_id` = " . $apDate[2] . " ");
        while ($row = mysql_fetch_assoc($per)) {
            //-- проверка существ. такой же ссылки в такой же категории
            if ($row["name"] == $apDate[1]) {
                $sameNameLink = true;
                $flag[0] = 6;
                break;
            }
        }

        //=====  IF NAME LINK IS NOT
        if (!$sameNameLink) {

            //=====  if just transfer link
            if ($apDate[7] == 0) {

                //-- функция увеличения кол элем. категории на один
                $pes = mysql_query(" SELECT `kol` FROM `$tbCat` WHERE `id` = '" . $apDate[2] . "' ");
                $row = mysql_fetch_row($pes);
                $kolLin = $row[0];
                $kolLin = $kolLin + 1;

                //-- ПОЛНОЕ ОБНАВЛЕНИЕ УКАЗАННОЙ ССЫЛКИ
                $apdate = mysql_query(" UPDATE `$tbLink` SET `name` = '" . $apDate[1] . "',
                                                             `number` = '" . $kolLin . "',
                                                             `group_id` = '" . $apDate[2] . "',
                                                             `icon` = '" . $apDate[3] . "',
                                                             `group` = '" . $apDate[9] . "',
                                                             `background` = '" . $apDate[4] . "',
                                                             `title` = '" . $apDate[6] . "'
                                                         WHERE id = " . $apDate[0] . " ");

                apdCountLinks($apDate[2], $tbLink, $tbCat);  //-- ФУНКЦИЯ ПОДСЧЁТА ЭЛЕМЕНТОВ. В НОВОЙ ГРУППЕ
                apdCountLinks($apDate[8], $tbLink, $tbCat);  //-- ФУНКЦИЯ ПОДСЧЁТА ЭЛЕМЕНТОВ. В ПРЕДЫД. ГРУППЕ

                //-- БЛОК ОПРЕДЕЛЕНИЯ НОМЕРА ЭЛЕМЕНТА
                $pes = mysql_query(" SELECT `number` FROM `$tbLink` WHERE `id` = '" . $apDate[0] . "' ");
                $row = mysql_fetch_row($pes);
                $nomEllin = $row[0];

                //-- БЛОК ОПРЕДЕЛЕНИЯ КОЛИЧ. ССЫЛОК В КАТЕГОРИИ
                $pes = mysql_query(" SELECT `kol` FROM `$tbCat` WHERE `id` = '" . $apDate[8] . "' ");
                $row = mysql_fetch_row($pes);
                $count = $row[0];

                //------ ФОРМИРОВАНИЕ НОВОГО ПОРЯДКА НОМЕРОВ  ---------
                for ($i = $nomEllin; $i < ($count + 1); $i++) {
                    $x = $i + 1;
                    mysql_query(" UPDATE `$tbLink` SET `number`='" . $i . "' WHERE `group_id` = '" . $apDate[8] . "' AND `number` = '" . $x . "' ");
                }

                $flag[0] = 4; //=====  transfer links and set params and name

            } else {

                $now = date("Y-d-m H:i:s");

                //-- ИЗМЕНЕНИЕ ФОНА ПОСТАВЛЕННОГО ПО УМОЛЧАНИЮ
                if ($apDate[4] == '#000000' || $apDate[4] == '') $apDate[4] = '#74AAF6';

                //-- функция присвоения измен. ссылки в нов. катег. последнего элемента
                $pes = mysql_query(" SELECT `kol` FROM `$tbCat` WHERE `id` = '" . $apDate[2] . "' ");
                $row = mysql_fetch_row($pes);
                $kolLin = $row[0];
                $kolLin = $kolLin + 1;

                //-- ЗАПИСЬ САМОЙ ССЫЛКИ
                mysql_query("INSERT INTO `$tbLink` (
                                                    `name`,
                                                    `group_id`,
                                                    `group`,
                                                    `icon`,
                                                    `number`,
                                                    `background`,
                                                    `title`,
                                                    `data`
                                                    )
                                            VALUES (
                                                    '" . $apDate[1] . "',
                                                    '" . $apDate[2] . "',
                                                    '" . $apDate[9] . "',
                                                    '" . $apDate[3] . "',
                                                    '" . $kolLin . "',
                                                    '" . $apDate[4] . "',
                                                    '" . $apDate[6] . "',
                                                    '" . $now . "'
                                                    )
                                            ");

                $flag[1] = mysql_insert_id();
                apdCountLinks($apDate[2], $tbLink, $tbCat);  //-- ФУНКЦИЯ ПОДСЧЁТА ЭЛЕМЕНТОВ. В ПРЕДЫД. ГРУППЕ
                $flag[0] = 45; //=====  create new link
            }
        }
    }

    //-----
    header('Content-Type: application/json;charset=utf-8');
    print json_encode($flag);
}


//===== FUNCTION ==================================================================================================

//-- ФУНКЦИЯ ПОДСЧЁТА КОЛИЧЕСТВА ЭЛЕМЕНТОВ В КАТЕГОРИИ
function apdCountLinks($name, $tbLink, $tbCat) {
    $pes = mysql_query(" SELECT COUNT(`id`) FROM `$tbLink` WHERE `group_id` = '".$name."' ");
    $row = mysql_fetch_row($pes);
    $count = $row[0];

    mysql_query(" UPDATE `$tbCat` SET `kol` = '".$count."' WHERE `id` = '".$name."' ");
}


