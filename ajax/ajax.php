<?php
require_once '../config.php';

$_POST['vodca'] = (isset($_POST['vodca']))?$_POST['vodca']:'&&&&';

$mes = array();

//$per = mysql_query(" SELECT `name` FROM `$tbCat` ORDER BY `number` ");


if($_POST['vodca'] != '&&&&') {

	$per = mysql_query(" SELECT * FROM `$tbLink` ORDER BY `number` ");

	while ($row = mysql_fetch_assoc($per)) 
	{
		//if($row["group"] == "HTML" ){
			$mes[] = $row;
		//}
	}

	header('Content-Type: application/json; charset=utf-8');
	print json_encode($mes);
}
//-------------------------------


//--  ВЫВОД ПОСЛЕДНИХ ДВАДЦАТИ ССЫЛОК
$_POST['query'] = (isset($_POST['query']))?$_POST['query']:'&&&&';

$mes = array();

if($_POST['query'] != '&&&&') {

	$per = mysql_query(" SELECT * FROM `$tbLink` ORDER BY `id` DESC  LIMIT  ".$_POST['query']['count']." OFFSET ".$_POST['query']['offset']." ");

	while ($row = mysql_fetch_assoc($per)) {
		$mes[] = $row;
	}

	header('Content-Type: application/json; charset=utf-8');
	print json_encode($mes);
}
//-------------------------------


//=====  ВЫВОДА ССЫЛОК КАТЕГОРИИ "ГЛАВНЫЕ"
$_POST['mainLinks'] = (isset($_POST['mainLinks']))?$_POST['mainLinks']:'&&&&';

$mes = array();

if($_POST['mainLinks'] != '&&&&') {

	$per = mysql_query(" SELECT * FROM `$tbLink` WHERE `group_id` = 16 ORDER BY `number`  ");

	while ($row = mysql_fetch_assoc($per)) {
		$mes[] = $row;
	}

	header('Content-Type: application/json; charset=utf-8');
	print json_encode($mes);
}

//-------------------------------

//--  ВЫВОДА ССЫЛОК КАТЕГОРИИ "ГЛАВНЫЕ"
$_POST['printLstLink'] = (isset($_POST['printLstLink']))?$_POST['printLstLink']:'&&&&';

$mes = array();

if($_POST['printLstLink'] != '&&&&') {

//	$per = mysql_query(" SELECT * FROM `$tbLink` ORDER BY `id` DESC  LIMIT 1 ");
	$per = mysql_query(" SELECT * FROM `$tbLink` WHERE `id` = '".$_POST['printLstLink']."' ");

	while ($row = mysql_fetch_assoc($per)) {
		$mes[0] = $row;
	}

	header('Content-Type: application/json; charset=utf-8');
	print json_encode($mes);
}


//======================================================================
//======================================================================
//======================================================================
//======================================================================

//--  ВЫВОДА ССЫЛОК КАТЕГОРИИ "ГЛАВНЫЕ"
$_POST['rewrite'] = (isset($_POST['rewrite']))?$_POST['rewrite']:'&&&&';

$mes = array();

if($_POST['rewrite'] != '&&&&') {


    $per = mysql_query(" SELECT * FROM `$tbCat` ORDER BY `id` DESC");

    while ($row = mysql_fetch_assoc($per))
    {

        $tabl = mysql_query(" SELECT * FROM `$tbLink` ORDER BY `id` DESC");

        while ($rowTable = mysql_fetch_assoc($tabl))
        {
            $mes[] = $rowTable['id'];
            $apdate = mysql_query("UPDATE `$tbLink` SET `group_id` = '".$row['id']."' WHERE `id` = '".$rowTable['id']."' AND `group` = '".$row['name']."' ");
        }
    }

    header('Content-Type: application/json; charset=utf-8');
    print json_encode($mes);
}

//======================================================================
//======================================================================
//======================================================================
//======================================================================