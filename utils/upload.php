<?php
	include "db.php";
//	include "myrrix.php";
	if(isset($_POST["uid"])) {
		$userId = $_POST["uid"];	
	}
	if(isset($_POST["name"])) {
		$instanceName = $_POST["name"];	
	}
	if(isset($_POST["port"])) {
		$port = $_POST["port"];	
	}
	if(isset($_POST["weights"])) {
		$weights = $_POST["weights"];
		$weightsarray = explode(",", $_POST["weights"]);
	}
	print_r($weightsarray);

	$fileName = date("mdyHis").".csv";
	$fileContent = file_get_contents($_FILES['file']['tmp_name']);	
	file_put_contents("../files/{$fileName}", $fileContent);
	insertInstance($userId,$port,$fileName,$instanceName,$weights);
