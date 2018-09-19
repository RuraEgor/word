<?php
require_once 'config.php';

$per = mysql_query(" SELECT * FROM `$tbLink` WHERE `id` = '1283' ");

while ($row = mysql_fetch_assoc($per)) {
    print_r($row);
}

echo '<br><br><br>';
echo '<hr>';
echo '<br><br><br>';
print_r($per);

echo '<hr>';
echo '<br><br><br>';

$pes = mysql_query(" SELECT COUNT(`id`) FROM `$tbLink` WHERE `group_id` = '357' ");
$row = mysql_fetch_row($pes);
$count = $row[0];
echo $count;

echo '<hr><hr>';
echo '<br><br><br>';

echo '<hr><hr>';
echo '<br><br><br>';

$pes = mysql_query(" SELECT COUNT(`id`) FROM `$tbCat` ");
$row = mysql_fetch_row($pes);
$count = $row[0];
echo $count;
echo 'nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn';

//=================================================

//-- БЛОК ОПРЕДЕЛЕНИЯ КОЛИЧ. КАТЕГОРИЙ
$per = mysql_query(" SELECT `id` FROM `$tbCat` ");

$i = 1;
while ($row = mysql_fetch_assoc($per)) {
    mysql_query(" UPDATE `$tbCat` SET `number`='" . $i . "' WHERE `id` = '" . $row['id'] . "' ");
    $i++;
    echo '<br><br>';
    echo $i;
}


////------ ФОРМИРОВАНИЕ НОВОГО ПОРЯДКА НОМЕРОВ КАТЕГОРИЙ  ---------
//for ($i = $paramGr[2]; $i < ($count + 1); $i++) {
//    $x = $i + 1;
//    mysql_query(" UPDATE `$tbCat` SET `number`='" . $i . "' WHERE `number` = '" . $x . "' ");
//}
