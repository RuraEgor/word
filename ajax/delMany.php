<?php

require_once '../config.php';

$_POST['nameLinks'] = (isset($_POST['nameLinks']))?$_POST['nameLinks']:'&&&';

if($_POST['nameLinks'] != '&&&') {

$nameLinks = $_POST['nameLinks'];
$flag = 0;


	for($i = 0; $i < count($nameLinks); $i++){
		
		/*
		//--  ОПРЕДЕЛЕНИЕ ГРУППЫ УДАЛЯЕМОЙ ССЫЛКИ
		$nameGrLn = mysql_query(" SELECT `group` FROM `$tbLink` WHERE `id` = '".$nameLinks[$i]."'  ");
		$row = mysql_fetch_row($nameGrLn);
		$group = $row[0];
		
		//--  УДАЛЕНИЕ ССЫЛКИ
		$prov = mysql_query(" DELETE FROM `$tbLink` WHERE ( `id` = '".$nameLinks[$i]."' ) ");
		
		//-- БЛОК ОПРЕДЕЛЕНИЯ КОЛИЧ. ССЫЛОК В КАТЕГОРИИ
		$pes = mysql_query(" SELECT COUNT(*) FROM `$tbLink` WHERE `group` = '".$group."' ");
		$row = mysql_fetch_row($pes);
		$count = $row[0];
		mysql_query(" UPDATE `$tbCat` SET `kol` = '".$count."' WHERE `name` = '".$group."' ");
		*/
	
		//------  ОПРЕЛЕЛЕНИЕ НОМЕРА ЭЛЕМЕНТА  ---------
		$nomElem = mysql_query(" SELECT `number`,`group_id` FROM `$tbLink` WHERE `id` = '".$nameLinks[$i]."' ");

		while( $roww = mysql_fetch_assoc($nomElem)) {
			$nomEl[0] = $roww['number'];  //-- номер удаляемой ссылки
			$nomEl[1] = $roww['group'];  //-- группа удаляемой ссылки
		}


		//------  УДАЛЕНИЕ НУЖНОГО ЭЛЕМЕНТА  ----------
			$prov = mysql_query(" DELETE FROM `$tbLink` WHERE ( `id` = '".$nameLinks[$i]."' ) ");

		
		if($prov){	//------  ПРОВЕРКА СУЩЕСТВОВАНИЯ УДАЛЁННОГО ЭЛЕМЕНТА  ----------

			//-- БЛОК ОПРЕДЕЛЕНИЯ КОЛИЧ. ССЫЛОК В КАТЕГОРИИ
			$pes = mysql_query(" SELECT COUNT(*) FROM `$tbLink` WHERE `group_id` = '".$nomEl[1]."' ");
			$row = mysql_fetch_row($pes);
			$count = $row[0];
			mysql_query(" UPDATE `$tbCat` SET `kol` = '".$count."' WHERE `name` = '".$nomEl[1]."' ");
		/**/
			//------ ФОРМИРОВАНИЕ НОВОГО ПОРЯДКА НОМЕРОВ  ---------
			for($j = $nomEl[0]; $j < ($count + 1); $j++){
				$x = $j + 1;
				
				mysql_query(" UPDATE `$tbLink` SET `number`='".$j."' WHERE `group_id` = '".$nomEl[1]."' AND `number` = '".$x."' ");
			}
		}
		
	}
	
	
//if($prov) {
	header('Content-Type: application/json; charset=utf-8');	
	print json_encode("yes");
//}

}