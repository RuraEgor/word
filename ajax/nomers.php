<?php
require_once '../config.php';


$masEl = (isset($_POST['masEl']))?$_POST['masEl']:'$?!';

if($masEl != '$?!') {

	//------  ОПРЕДЕЛ. ОБЩЕГО КОЛИЧЕСТВА ЭЛЛЕМЕНТОВ  -------
    $kolElem = count($masEl);

	//------ ФОРМИРОВАНИЕ НОВОГО ПОРЯДКА НОМЕРОВ  --------
	for($i = 1; $i < $kolElem; $i++){
		mysql_query(" UPDATE `$tbLink` SET `number`='".$i."' WHERE `id` = '".$masEl[$i]."' ");
	}

	header('Content-Type: application/json; charset=utf-8');	
	print json_encode();
}

//----------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------

$masElCar = (isset($_POST['masElCar']))?$_POST['masElCar']:'$?!';

if($masElCar != '$?!') {

	//------  ОПРЕДЕЛ. ОБЩЕГО КОЛИЧЕСТВА ЭЛЛЕМЕНТОВ  -------
	$kolElem = count($masElCar);
	
	//------ ФОРМИРОВАНИЕ НОВОГО ПОРЯДКА НОМЕРОВ  --------
	for($i = 1; $i < $kolElem; $i++){
		$val = mysql_query(" UPDATE `$tbCat` SET `number`='".$i."' WHERE `id` = '".$masElCar[$i]."' ");

		//$val = mysql_query(" UPDATE `$tbCat8` SET `number`='".$i."' WHERE `id` = '".$masElCar[$i]."' ");
	}
	
	header('Content-Type: application/json; charset=utf-8');
	print json_encode($kolElem);
}
